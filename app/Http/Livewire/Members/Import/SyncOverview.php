<?php

namespace App\Http\Livewire\Members\Import;

use App\Models\Import\ImportedMember;
use App\Models\Import\MemberChangesWrapper;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Collection;
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
     * @param Collection<int, Member> $currentMemberList
     * @param ImportedMember $importedMember
     * @return Member
     */
    private function findMatchingMember(Collection $currentMemberList, ImportedMember $importedMember): Member
    {
        if ($importedMember->hasAttribute("external_id")) {
            return $this->findExternalIdInMemberList($currentMemberList,
                $importedMember->getAttribute("external_id"));
        }

        if ($importedMember->hasAttribute("firstname") &&
            $importedMember->hasAttribute("lastname") &&
            $importedMember->hasAttribute("birthday")) {
            return $this->findNameAndBirthdayInMemberList(
                $currentMemberList,
                $importedMember->getAttribute("lastname"),
                $importedMember->getAttribute("firstname"),
                $importedMember->getAttribute("birthday"));
        }
        throw new ItemNotFoundException();
    }

    /**
     * @param Collection<int, Member> $currentMemberList
     * @param string $externalId
     * @return Member
     * @throws ItemNotFoundException
     */
    private function findExternalIdInMemberList(Collection $currentMemberList, string $externalId): Member
    {
        return $currentMemberList->firstOrFail("external_id", "==", $externalId);
    }

    /**
     * @param Collection<int, Member> $currentMemberList
     * @param string $lastname
     * @param string $firstname
     * @param Carbon $birthday
     * @return Member
     * @throws ItemNotFoundException
     */
    private function findNameAndBirthdayInMemberList(
        Collection $currentMemberList,
        string     $lastname,
        string     $firstname,
        Carbon     $birthday): Member
    {
        return $currentMemberList->firstOrFail(function (Member $member) use ($lastname, $firstname, $birthday) {
            return $member->lastname === $lastname &&
                $member->firstname === $firstname &&
                $member->birthday?->toDateString() === $birthday->toDateString();
        });
    }

    public function hydrate()
    {
        $this->newMembers = array_map(fn(array $e) => new ImportedMember($e), $this->newMembers);
        $this->changedMembers = array_map(function (array $wrapper) {
            return new MemberChangesWrapper(
                new Member($wrapper["original"]),
                new ImportedMember($wrapper["imported"]),
                $wrapper["attributeDifferenceList"]
            );
        }, $this->changedMembers);
    }

    public function syncMembers()
    {
        $newAdded = 0;
        foreach ($this->newMembers as $importedMember) {
            $newMember = $importedMember->toMember();
            $newMember->last_import_date = now();
            if (!$newMember->entrance_date)
                $newMember->entrance_date = $newMember->last_import_date;
            if ($newMember->saveQuietly()) $newAdded++;
        }

        session()->push("message", __(":count new members created during import.", ["count" => $newAdded]));
    }

    public function render()
    {
        return view('livewire.members.import.sync-overview');
    }
}
