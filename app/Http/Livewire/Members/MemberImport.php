<?php

namespace App\Http\Livewire\Members;

use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class MemberImport extends Component
{
    use WithFileUploads;

    public null|TemporaryUploadedFile|string $csvFile = null;
    public string $fileInfoMessage = "";
    public string $separator = ";";
    public array $csvColumns = [];
    public string $csvColumnsHash = "";
    public array $rawData = [];

    protected function rules()
    {
        return [
            'csvFile' => ['required', File::types(['csv', 'txt'])->max(1024)],
            'separator' => ['required', Rule::in([';',','])]
        ];
    }

    public function mount() {
        $this->fileInfoMessage = __("Please select a valid csv file.");
    }

    public function evaluateFile()
    {
        $this->validate();

        $lines = explode("\n", $this->csvFile?->get());
        $this->rawData = Arr::map($lines, fn($elem) => str_getcsv($elem, $this->separator));
        $this->filterRawData();
        $this->csvColumns = array_shift($this->rawData);
        if(count($this->rawData) < 2 || count($this->csvColumns) < 3) {
            $this->fileInfoMessage = __("Given file is not usable for member import");
            $this->csvColumns = [];
            $this->rawData = [];
            return;
        }
        $this->csvColumnsHash = md5(json_encode($this->csvColumns));
        $this->fileInfoMessage = "";
    }

    private function filterRawData(): void {
        $this->rawData = array_filter($this->rawData, function($rowEntry) {
            return is_array($rowEntry) && count($rowEntry) > 1;
        });
    }

    public function render()
    {
        return view('livewire.members.member-import')->layout('layouts.backend');
    }
}
