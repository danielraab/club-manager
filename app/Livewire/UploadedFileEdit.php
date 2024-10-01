<?php

namespace App\Livewire;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\UploadedFileForm;
use App\Models\UploadedFile;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use App\Repositories\UploadedFileStorage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class UploadedFileEdit extends Component
{
    use WithFileUploads;

    public UploadedFileForm $uploadedFileForm;

    #[Validate(['newFile' => 'file|max:10240'])]
    public ?TemporaryUploadedFile $newFile = null;

    public function mount(UploadedFile $uploadedFile): void
    {
        $this->uploadedFileForm->setModel($uploadedFile);
    }

    /**
     * @throws ValidationException
     */
    public function saveUploadedFile(): void
    {
        $this->uploadedFileForm->update();
        NotificationMessage::addNotificationMessage(
            new Item(__('File information updated.'), ItemType::SUCCESS));
    }

    public function deleteUploadedFile()
    {
        $fileRemoved = $this->uploadedFileForm->uploadedFile->removeFile();
        $fileDeleted = $this->uploadedFileForm->uploadedFile->delete();

        $message = 'Uploaded file was '.($fileRemoved ? 'removed' : 'not removed').
            ' and '.($fileDeleted ? 'deleted' : 'not deleted');
        Log::info($message, [auth()->user(), $this->uploadedFileForm->uploadedFile]);
        NotificationMessage::addInfoNotificationMessage(__($message));

        return $this->redirect(route('uploaded-file.list'));
    }

    public function changeFile(): void
    {
        $this->validate();

        $user = auth()->user();
        $storage = UploadedFileStorage::make();
        $path = $storage->storeTemporaryUploadedFile($this->newFile);

        $this->uploadedFileForm->uploadedFile->path = $path;

        $this->uploadedFileForm->uploadedFile->name = $this->newFile->getClientOriginalName();
        $this->uploadedFileForm->uploadedFile->mimeType = $this->newFile->getMimeType();

        $this->uploadedFileForm->uploadedFile->save();

        $this->uploadedFileForm->setModel($this->uploadedFileForm->uploadedFile);

        Log::info('Uploaded file updated', [$user, $this->uploadedFileForm->uploadedFile]);
        NotificationMessage::addNotificationMessage(
            new Item(__('File uploaded.'), ItemType::SUCCESS));
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.uploaded-file-edit')->layout('layouts.backend');
    }
}
