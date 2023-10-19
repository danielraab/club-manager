<?php

namespace App\Livewire\Members\Import;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class MemberImport extends Component
{
    use WithFileUploads;

    public null|TemporaryUploadedFile|string $csvFile = null;

    public string $fileInfoMessage = '';

    public string $separator = ';';

    public array $csvColumns = [];

    public string $csvColumnsHash = '';

    public array $rawData = [];

    protected function rules()
    {
        return [
            'csvFile' => ['required', File::types(['csv', 'txt'])->max(1024)],
            'separator' => ['required', Rule::in([';', ','])],
        ];
    }

    public function mount()
    {
        $this->fileInfoMessage = __('Please select a valid import file.');
    }

    public function evaluateFile()
    {
        $this->fileInfoMessage = '';
        $this->validate();

        try {
            $this->readCSVFile();
            $this->parseHeadline();
        } catch (\Exception $e) {
            Log::info('error while reading/parsing csv file', [$e->getTraceAsString()]);
            $this->fileInfoMessage = 'Problem occurred while reading the csv file. Please check the file and try again.';
        }
    }

    /**
     * @throws FileNotFoundException
     */
    private function readCSVFile()
    {
        $lines = explode("\n", $this->csvFile?->get());
        $this->rawData = Arr::map($lines, fn ($elem) => str_getcsv($elem, $this->separator));
        $this->filterRawData();
    }

    private function filterRawData(): void
    {
        $this->rawData = array_filter($this->rawData, function ($rowEntry) {
            return is_array($rowEntry) && count($rowEntry) > 1;
        });
    }

    private function parseHeadline()
    {
        $this->csvColumns = array_shift($this->rawData);
        if (count($this->rawData) < 2 || count($this->csvColumns) < 3) {
            $this->fileInfoMessage = __('Given file is not usable for member import');
            $this->csvColumns = [];
            $this->rawData = [];
        }
        $this->csvColumnsHash = md5(json_encode($this->csvColumns));
    }

    public function render()
    {
        return view('livewire.members.import.member-import')->layout('layouts.backend');
    }
}
