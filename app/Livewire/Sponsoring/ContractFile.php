<?php

namespace App\Livewire\Sponsoring;

use App\Models\Sponsoring\Contract;
use App\Models\UploadedFile;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ContractFile extends Component
{
    use WithFileUploads;

    public Contract $contract;

    #[Validate(['contractFile' => 'file|mimes:png,jpg,pdf|max:10240'])]
    public ?TemporaryUploadedFile $contractFile = null;

    public function mount(Contract $contract): void
    {
        $this->contract = $contract;
    }

    public function uploadFile(): void
    {
        $this->validate();

        $user = auth()->user();
        $path = $this->contractFile->store("contract");
        $uploadedFile = new UploadedFile();
        $uploadedFile->path = $path;
        $uploadedFile->name = $this->contractFile->getClientOriginalName();
        $uploadedFile->mimeType = $this->contractFile->getMimeType();

        $uploadedFile->storer()->associate($this->contract);
        $uploadedFile->uploader()->associate($user);
        $uploadedFile->save();

        Log::info("Contract uploaded", [$user, $uploadedFile]);
        session()->flash('message', __('File uploaded.'));
    }

    public function deleteFile(UploadedFile $uploadedFile): void
    {
        $uploadedFile->delete();

        Log::info("Contract deleted.", [auth()->user(), $uploadedFile]);
        session()->flash('message', __('File(s) deleted.'));
    }

    public function render()
    {
        return view('livewire.sponsoring.contract-file')->layout('layouts.backend');
    }
}
