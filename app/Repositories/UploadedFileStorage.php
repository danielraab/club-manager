<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class UploadedFileStorage
{
    private bool $isPublic = false;

    private string $path;

    private bool $useOriginalName;

    public static function make(string $path = 'uploadedFiles', bool $useOriginalName = true): UploadedFileStorage
    {
        $storage = new UploadedFileStorage;

        $storage->path = $path;
        $storage->useOriginalName = $useOriginalName;

        return $storage;
    }

    public static function makePublic(string $path = 'uploadedFiles', bool $useOriginalName = true): UploadedFileStorage
    {
        $storage = new UploadedFileStorage;
        $storage->isPublic = true;
        $storage->path = $path;
        $storage->useOriginalName = $useOriginalName;

        return $storage;
    }

    public function storeTemporaryUploadedFile(TemporaryUploadedFile $file): bool|string
    {
        return $file->storeAs($this->getDestinationPath(), $this->getFilename($file));
    }

    private function getDestinationPath(): string
    {
        if ($this->isPublic) {
            return 'public/'.$this->path;
        }

        return $this->path;
    }

    private function getFilename(TemporaryUploadedFile $file): string
    {
        if ($this->useOriginalName) {
            return Str::random(5).'_'.$file->getClientOriginalName();
        }

        return $file->hashName();
    }
}
