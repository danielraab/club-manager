<?php

namespace App\Http\Livewire\Members\Import;

use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\ItemNotFoundException;
use Livewire\Component;

class SyncOverview extends Component
{
    public array $keyedData = [];

    public array $changedMembers = [];
    public array $unchangedImports = [];
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
        $currentMemberList = Member::all()->toArray();

        foreach ($this->keyedData as $importedMember) {
            try {
                $foundMember = $this->findMatchingMember($currentMemberList, $importedMember);
                $memberImportInfo = $this->calculateChangedProperties($foundMember, $importedMember);
                if (count($memberImportInfo["imports"]) > 0) {
                    $this->changedMembers[] = $memberImportInfo;
                } else {
                    $this->unchangedImports[] = $memberImportInfo;
                }

            } catch (ItemNotFoundException $e) {
                $this->newMembers[] = $importedMember;
            }
        }
    }

    private function findMatchingMember($currentMemberList, $importedMember): Member
    {
        if (isset($importedMember["external_id"])) {
            return $this->findExternalIdInMemberList($currentMemberList, $importedMember["external_id"]);
        }

        if (isset($importedMember["firstname"]) &&
            isset($importedMember["lastname"]) &&
            isset($importedMember["birthday"])) {
            return $this->findNameAndBirthdayInMemberList(
                $currentMemberList,
                trim($importedMember["lastname"]),
                trim($importedMember["firstname"]),
                new Carbon($importedMember["birthday"]));
        }
        throw new ItemNotFoundException();
    }

    private function findExternalIdInMemberList(array $currentMemberList, string $externalId): Member
    {
        $foundMembers = array_filter($currentMemberList, function ($member) use ($externalId) {
            return isset($member["external_id"]) && $member["external_id"] === $externalId;
        });
        return $foundMembers[0] ?? throw new ItemNotFoundException();
    }

    private function findNameAndBirthdayInMemberList(array $currentMemberList, string $lastname, string $firstname, Carbon $birthday): Member
    {
        $foundMembers = array_filter($currentMemberList, function ($member) use ($lastname, $firstname, $birthday) {
            return $member["lastname"] === $lastname &&
                $member["firstname"] === $firstname &&
                Carbon::parse($member["birthday"])->toDateString() === $birthday->toDateString();
        });
        return $foundMembers[0] ?? throw new ItemNotFoundException();
    }

    private function calculateChangedProperties($currentMember, $importedMember): array
    {
        $propertyDelta = [];
        foreach ($importedMember as $key => $value) {
            if ($currentMember[$key] !== $value) {
                $propertyDelta[$key] = $value;
            }
        }
        return [
            "original" => $currentMember,
            "imports" => $propertyDelta
        ];
    }

    public function syncMembers()
    {
    }

    public function render()
    {
        return view('livewire.members.import.sync-overview');
    }
}
