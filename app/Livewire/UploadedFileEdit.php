<?php

namespace App\Livewire;

use App\Models\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UploadedFileEdit extends Component
{
    public UploadedFile $uploadedFile;

    public function mount(UploadedFile $uploadedFile): void
    {
        $this->uploadedFile = $uploadedFile;
    }


    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.uploaded-file-edit')->layout('layouts.backend');
    }
}
