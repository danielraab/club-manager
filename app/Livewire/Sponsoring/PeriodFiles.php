<?php

namespace App\Livewire\Sponsoring;

use App\Models\Sponsoring\Period;
use App\Models\UploadedFile;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class PeriodFiles extends Component
{
    use WithFileUploads;

    public Period $period;

    /**
     * @var TemporaryUploadedFile[]
     */
    #[Validate(['periodFiles.*' => 'file|mimes:png,jpg,pdf|max:10240'])]
    public array $periodFiles = [];

    public function mount(Period $period): void
    {
        $this->period = $period;
    }

    public function uploadFiles(): void
    {
        $this->validate();

        $user = auth()->user();
        $uploadedFiles = [];
        foreach($this->periodFiles as $periodFile) {
            $path = $periodFile->store("period");
            $uploadedFile = new UploadedFile();
            $uploadedFile->path = $path;
            $uploadedFile->name = $periodFile->getClientOriginalName();
            $uploadedFile->mimeType = $periodFile->getMimeType();

            $uploadedFile->storer()->associate($this->period);
            $uploadedFile->uploader()->associate($user);
            $uploadedFile->save();

            $uploadedFiles[] = $uploadedFile->name;
        }
        $this->periodFiles = [];

        Log::info("Period files uploaded", [auth()->user(), $uploadedFiles]);
        session()->flash('message', __('Files uploaded.'));
    }

    public function deleteFile(UploadedFile $uploadedFile): void
    {
        $uploadedFile->delete();

        Log::info("Period file deleted.", [auth()->user(), $uploadedFile]);
        session()->flash('message', __('File(s) deleted.'));
    }

    public function render()
    {
        return view('livewire.sponsoring.period-files')->layout('layouts.backend');
    }
}
