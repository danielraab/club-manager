<?php

namespace App\Livewire;

use App\Models\UploadedFile;
use Livewire\Component;

class UploadedFiles extends Component
{
    public array $additionalFilesInFolder;

    public \Illuminate\Support\Collection|array|\Illuminate\Database\Eloquent\Collection $files;

    public function mount(): void
    {
        $this->additionalFilesInFolder = \Illuminate\Support\Facades\Storage::allFiles();
        $this->files = \App\Models\UploadedFile::withTrashed()->orderBy('storer_type', 'desc')->get();

        foreach ($this->files as $file) {
            /** @var UploadedFile $file */
            if ($key = array_search($file->path, $this->additionalFilesInFolder)) {
                unset($this->additionalFilesInFolder[$key]);
            }
        }
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('uploadedFiles')->layout('layouts.backend');
    }
}
