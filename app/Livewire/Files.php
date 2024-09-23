<?php

namespace App\Livewire;

use App\Models\UploadedFile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Files extends Component
{
    public array $additionalFilesInFolder;

    public Collection $files;

    public function mount(): void
    {
        $this->additionalFilesInFolder = Storage::allFiles();
        $this->files = UploadedFile::withTrashed()->orderBy('storer_type', 'desc')->get();

        foreach ($this->files as $file) {
            /** @var UploadedFile $file */
            if ($key = array_search($file->path, $this->additionalFilesInFolder)) {
                unset($this->additionalFilesInFolder[$key]);
            }
        }
    }

    public function forceDownload($path): ?StreamedResponse
    {
        if (Storage::exists($path)) {
            return Storage::download($path);
        }

        return null;
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.files')->layout('layouts.backend');
    }
}
