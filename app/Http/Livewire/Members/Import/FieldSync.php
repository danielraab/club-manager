<?php

namespace App\Http\Livewire\Members\Import;

use Illuminate\Support\Arr;
use Livewire\Component;

class FieldSync extends Component
{
    public const MEMBER_FIELD_ARRAY = [
        "firstname" => "Firstname",
        "lastname" => "Lastname",
        "external_id" => "External Id",
        "title_pre" => "Prefixed Title",
        "title_post" => "Postfixed Title",
        "entrance_date" => "Entrance date",
        "street" => "Street",
        "zip" => "ZIP",
        "city" => "City",
        "phone" => "Phone number",
        "email" => "Email",
        "birthday" => "Birthday"
    ];

    public array $csvColumns = [];
    public array $fieldMap = [];
    public array $rawData = [];
    public array $keyedData = [];
    public string $keyedDataHash = "";

    protected function rules()
    {
        return [
            'fieldMap' => 'array:' . implode(",", array_keys(self::MEMBER_FIELD_ARRAY)),
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
        $this->keyedData = Arr::map($this->rawData, function (array $csvLineEntry) {
            return array_combine(array_keys($this->fieldMap),
                Arr::map(array_values($this->fieldMap),
                    function ($csvColumnId) use ($csvLineEntry) {
                        return $csvLineEntry[intval($csvColumnId)];
                    }));
        });
        $this->keyedDataHash = md5(json_encode($this->keyedData));
    }

    public function render()
    {
        return view('livewire.members.import.field-sync');
    }
}
