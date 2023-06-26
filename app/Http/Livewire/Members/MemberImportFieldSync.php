<?php

namespace App\Http\Livewire\Members;

use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class MemberImportFieldSync extends Component
{
    public const MEMBER_FIELD_ARRAY = [
        "firstname" => "Firstname",
        "lastname" => "Lastname",
        "external_id" => "External Id",
        "title_pre" => "Prefixed Title",
        "title_post" => "Postfixed Title",
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

    protected function rules()
    {
        return [
            'fieldMap' => 'array:' . implode(",", array_keys(self::MEMBER_FIELD_ARRAY)),
        ];
    }

    public function showSyncOverview()
    {
        $this->validate();
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
    }

    public function render()
    {
        return view('livewire.members.member-import-field-sync');
    }
}
