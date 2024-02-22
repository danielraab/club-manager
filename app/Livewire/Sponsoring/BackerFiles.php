<?php

namespace App\Livewire\Sponsoring;

use App\Models\Sponsoring\Backer;
use App\Models\UploadedFile;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class BackerFiles extends Component
{
    use WithFileUploads;

    public Backer $backer;

    /**
     * @var TemporaryUploadedFile[]
     */
    #[Validate(['adDataArr.*' => 'file|mimes:png,jpg,pdf|max:10240'])]
    public array $adDataArr = [];

    public function mount(Backer $backer): void
    {
        $this->backer = $backer;
    }

    public function uploadFiles(): void
    {
        $this->validate();

        $uploadedFiles = [];
        foreach($this->adDataArr as $adData) {
            $path = $adData->store("backerData");
            $uploadedFile = new UploadedFile();
            $uploadedFile->path = $path;
            $uploadedFile->name = $adData->getClientOriginalName();
            $uploadedFile->mimeType = $adData->getMimeType();

            $uploadedFile->storer()->associate($this->backer);
            $uploadedFile->save();

            $uploadedFiles[] = $uploadedFile->name;
        }
        $this->adDataArr = [];

        Log::info("Backer Ad Data uploaded", [auth()->user(), $uploadedFiles]);
        session()->flash('message', __('Files uploaded.'));
    }

    public function deleteFile(UploadedFile $uploadedFile): void
    {
        $uploadedFile->delete();

        Log::info("Backer Ad Data deleted.", [auth()->user(), $uploadedFile]);
        session()->flash('message', __('File(s) deleted.'));
    }

    public function render()
    {
        return view('livewire.sponsoring.backer-files')->layout('layouts.backend');
    }
}
