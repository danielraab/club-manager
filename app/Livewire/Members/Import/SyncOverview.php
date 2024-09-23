<?php

namespace App\Livewire\Members\Import;

use App\Facade\NotificationMessage;
use App\Models\Import\ImportedMember;
use App\Models\Import\MemberChangesWrapper;
use App\Models\Member;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ItemNotFoundException;
use Livewire\Component;

class SyncOverview extends Component
{
    /**
     * @var ImportedMember[]
     */
    public array $importedMemberList = [];

    /**
     * @var MemberChangesWrapper[]
     */
    public array $changedMembers = [];

    /**
     * @var ImportedMember[]
     */
    public array $unchangedImports = [];

    /**
     * @var ImportedMember[]
     */
    public array $newMembers = [];

    public function mount(): void
    {
        $this->calculateSyncResult();
    }

    private function calculateSyncResult(): void
    {
        $this->changedMembers = [];
        $this->unchangedImports = [];
        $this->newMembers = [];
        $currentMemberList = Member::all()->toBase();

        foreach ($this->importedMemberList as $importedMember) {
            try {
                $foundMember = $this->findMatchingMember($currentMemberList, $importedMember);
                $diffPropList = $importedMember->getDifferences($foundMember);
                if (empty($diffPropList)) {
                    $this->unchangedImports[] = $importedMember;
                } else {
                    $this->changedMembers[] = new MemberChangesWrapper(
                        $foundMember, $importedMember, $diffPropList
                    );
                }
            } catch (ItemNotFoundException $e) {
                $this->newMembers[] = $importedMember;
            }
        }
    }

    /**
     * @param  Collection<int, Member>  $currentMemberList
     */
    private function findMatchingMember(Collection $currentMemberList, ImportedMember $importedMember): Member
    {
        if ($importedMember->hasAttribute('external_id')) {
            return $this->findExternalIdInMemberList($currentMemberList,
                $importedMember->getAttribute('external_id'));
        }

        if ($importedMember->hasAttribute('firstname') &&
            $importedMember->hasAttribute('lastname') &&
            $importedMember->hasAttribute('birthday')) {
            return $this->findNameAndBirthdayInMemberList(
                $currentMemberList,
                $importedMember->getAttribute('lastname'),
                $importedMember->getAttribute('firstname'),
                $importedMember->getAttribute('birthday'));
        }
        throw new ItemNotFoundException;
    }

    /**
     * @param  Collection<int, Member>  $currentMemberList
     *
     * @throws ItemNotFoundException
     */
    private function findExternalIdInMemberList(Collection $currentMemberList, string $externalId): Member
    {
        return $currentMemberList->firstOrFail('external_id', '==', $externalId);
    }

    /**
     * @param  Collection<int, Member>  $currentMemberList
     *
     * @throws ItemNotFoundException
     */
    private function findNameAndBirthdayInMemberList(
        Collection $currentMemberList,
        string $lastname,
        string $firstname,
        Carbon $birthday): Member
    {
        return $currentMemberList->firstOrFail(function (Member $member) use ($lastname, $firstname, $birthday) {
            return $member->lastname === $lastname &&
                $member->firstname === $firstname &&
                $member->birthday?->toDateString() === $birthday->toDateString();
        });
    }

    public function hydrate()
    {
        $this->newMembers = array_map(fn (array $e) => new ImportedMember($e), $this->newMembers);
        $this->changedMembers = array_map(function (array $wrapper) {
            $originalMember = new Member($wrapper['original']);
            $originalMember->id = $wrapper['original']['id'];

            return new MemberChangesWrapper(
                $originalMember,
                new ImportedMember($wrapper['imported']),
                $wrapper['attributeDifferenceList']
            );
        }, $this->changedMembers);
    }

    public function syncMembers()
    {
        $addedCnt = 0;
        $updatedCnt = 0;
        try {
            DB::beginTransaction();
            foreach ($this->newMembers as $importedMember) {
                $newMember = $importedMember->toMember();
                $newMember->last_import_date = now();
                if (! $newMember->entrance_date) {
                    $newMember->entrance_date = $newMember->last_import_date;
                }

                $newMember->creator()->associate(Auth::user());
                $newMember->lastUpdater()->associate(Auth::user());

                if ($newMember->saveQuietly()) {
                    $addedCnt++;
                }
            }

            foreach ($this->changedMembers as $memberWrapper) {
                $id = $memberWrapper->original->id;
                $member = Member::query()->find($id);
                $member->lastUpdater()->associate(Auth::user());
                if ($member->update($memberWrapper->imported->getAttributes())) {
                    $updatedCnt++;
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('exception occurred while syncing imported members.', [$e]);
            NotificationMessage::addNotificationMessage(
                new Item(
                    __('An error occurred while syncing the imported members. Check your import file and try again.'),
                    ItemType::ERROR));

            return redirect();
        }

        if ($addedCnt > 0) {
            NotificationMessage::addNotificationMessage(
                new Item(__(':count new members created during import.', ['count' => $addedCnt]), ItemType::SUCCESS));
        }
        if ($updatedCnt > 0) {
            NotificationMessage::addNotificationMessage(
                new Item(__(':count members updated during import.', ['count' => $updatedCnt]), ItemType::SUCCESS));
        }

        return redirect(route('member.index'));
    }

    public function render()
    {
        return view('livewire.members.import.sync-overview');
    }
}
