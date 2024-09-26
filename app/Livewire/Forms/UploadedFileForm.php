<?php

namespace App\Livewire\Forms;

use App\Models\News;
use App\Models\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UploadedFileForm extends Form
{
    public ?UploadedFile $uploadedFile;

    #[Validate('max:255')]
    public ?string $name = null;

    public ?string $mimeType = null;

    public bool $isPublic = false;


    public function setModel(UploadedFile $uploadedFile): void
    {
        $this->uploadedFile = $uploadedFile;
        $this->name = $uploadedFile->name;
        $this->mimeType = $uploadedFile->mimeType;
        $this->isPublic = $uploadedFile->isPublic;
    }

    public function delete(): void
    {
        $this->uploadedFile?->delete();
    }

    /**
     * @throws ValidationException
     */
    public function update(): void
    {
        $this->validate();

        $this->uploadedFile->update([
            ...$this->except('uploadedFile'),
        ]);
        $this->uploadedFile->save();
    }

}
