<?php

namespace App\Http\Livewire\Members\Import;

use App\Models\Import\ImportedMember;
use Livewire\Component;

class FieldSync extends Component
{
    public array $csvColumns = [];
    public array $fieldMap = [];
    public array $rawData = [];

    /**
     * @var ImportedMember[]
     */
    protected array $importedMemberList = [];
    public string $importedMemberListHash = "";

    protected function rules()
    {
        return [
            'fieldMap' => 'array:' . implode(",", ImportedMember::possibleAttributeNames()),
        ];
    }

    public function showSyncOverview()
    {
        $this->validate();
        //remove empty values from associative array
        $this->fieldMap = array_filter($this->fieldMap, function ($value, $key) { return is_numeric($value);},ARRAY_FILTER_USE_BOTH);
        $this->transformCSVData();
    }

    private function transformCSVData()
    {
        $this->importedMemberList = [];
        $this->importedMemberListHash = "";
        foreach ($this->rawData as $csvLine) {
            $importedMember = new ImportedMember();
            foreach($this->fieldMap as $propertyName => $csvColumnId) {
                $importedMember->setAttribute($propertyName, $csvLine[intval($csvColumnId)]);
            }
            $this->importedMemberList[] = $importedMember;
        }
        $this->importedMemberListHash = md5(json_encode($this->importedMemberList));
    }

    public function render()
    {
        return view('livewire.members.import.field-sync', [
            "importedMemberList" => $this->importedMemberList
        ]);
    }
}
