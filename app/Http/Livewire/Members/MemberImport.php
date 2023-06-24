<?php

namespace App\Http\Livewire\Members;

use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class MemberImport extends Component
{
    use WithFileUploads;

    public null|TemporaryUploadedFile|string $csvFile = null;
//    public string $fileContent = "";
    public string $fileInformation = "";
    public string $separator = ";";
    public array $columnArray = [];
    public array $data = [];

    protected function rules()
    {
        return [
            'csvFile' => ['required', File::types(['csv', 'txt'])->max(1024)],
            'separator' => ['required', Rule::in([';',','])]
        ];
    }

    public function mount() {
        $this->fileInformation = __("Please select a valid csv file.");
    }

    public function evaluateFile()
    {
        $this->validate();

        $lines = explode("\n", $this->csvFile?->get());
        $this->data = Arr::map($lines, fn($elem) => str_getcsv($elem, $this->separator));
        $this->columnArray = array_shift($this->data);
        if(count($this->columnArray) < 3) {
            $this->fileInformation = "Given file is not usable for member import";
            $this->columnArray = [];
            $this->data = [];
        }
    }

    public function render()
    {
        return view('livewire.members.member-import')->layout('layouts.backend');
    }
}
