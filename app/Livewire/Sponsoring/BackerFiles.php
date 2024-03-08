<?php

namespace App\Livewire\Sponsoring;

use App\Facade\NotificationMessage;
use App\Models\Sponsoring\Backer;
use App\Models\UploadedFile;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
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
    #[Validate(['adDataFiles.*' => 'file|mimes:png,jpg,pdf|max:10240'])]
    public array $adDataFiles = [];

    public function mount(Backer $backer): void
    {
        $this->backer = $backer;
    }

    public function uploadFiles(): void
    {
        $this->validate();

        $user = auth()->user();
        $uploadedFiles = [];
        foreach ($this->adDataFiles as $adData) {
            $path = $adData->store("backerData");
            $uploadedFile = new UploadedFile();
            $uploadedFile->path = $path;
            $uploadedFile->name = $adData->getClientOriginalName();
            $uploadedFile->mimeType = $adData->getMimeType();

            $uploadedFile->storer()->associate($this->backer);
            $uploadedFile->uploader()->associate($user);
            $uploadedFile->save();

            $uploadedFiles[] = $uploadedFile->name;
        }
        $this->adDataFiles = [];

        Log::info("Backer Ad Data uploaded", [auth()->user(), $uploadedFiles]);
        NotificationMessage::addNotificationMessage(
            new Item(__('Files uploaded.'), ItemType::SUCCESS));
    }

    public function deleteFile(UploadedFile $uploadedFile): void
    {
        $uploadedFile->delete();

        Log::info("Backer Ad Data deleted.", [auth()->user(), $uploadedFile]);
        NotificationMessage::addNotificationMessage(
            new Item(__('File(s) deleted.'), ItemType::WARNING));
    }

    public function render()
    {
        return view('livewire.sponsoring.backer-files')->layout('layouts.backend');
    }
}
