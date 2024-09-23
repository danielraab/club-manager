<?php

namespace App\Http\Controllers;

use App\Models\UploadedFile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function download(UploadedFile $file): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $this->checkPermission($file);

        return Storage::download($file->path, $file->name);
    }

    public function response(UploadedFile $file): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $this->checkPermission($file);

        return Storage::response($file->path, $file->name);
    }

    private function checkPermission(UploadedFile $file): void
    {
        if (! Storage::fileExists($file->path)) {
            Log::warning('file does not exist', ['file' => $file]);
            throw new ModelNotFoundException;
        }
        if (! $file->hasAccess()) {
            Log::warning('user has no access', ['file' => $file, 'user' => auth()->user()]);
            throw new ModelNotFoundException;
        }
    }
}
