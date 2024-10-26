<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * @property int id
 * @property string name
 * @property string mimeType
 * @property string path
 * @property bool isPublic
 * @property int uploader_id
 * @property User|null uploader
 * @property Model|null storer
 * @property Carbon created_at
 *
 * @see /database/migrations/2024_01_20_152805_create_updated_files_tables.php
 */
class UploadedFile extends Model
{
    use SoftDeletes;

    protected $casts = [
        'isPublic' => 'boolean',
    ];

    protected $fillable = [
        'isPublic',
        'name',
        'mimeType',
    ];

    public function storer(): MorphTo
    {
        return $this->morphTo();
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hasAccess(): bool
    {
        if ($this->isPublic) {
            return true;
        }

        /** @var $storer HasFileRelationInterface */
        if (($storer = $this->storer()->first()) instanceof HasFileRelationInterface) {
            return $storer->hasFileAccess(auth()->user());
        }

        return false;
    }

    public function removeFile(): bool
    {
        if (Storage::fileExists($this->path)) {
            return Storage::delete($this->path);
        }

        return false;
    }

    public function isPublicStored(): bool
    {
        return str_starts_with($this->path, 'public');
    }

    public function getUrl(): string
    {
        if ($this->isPublicStored()) {
            return url(Storage::url($this->path));
        }

        return route('file', $this->id);
    }
}
