<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string name
 * @property string mimeType
 * @property string path
 * @property bool forcePublic
 * @property int uploader_id
 * @property User|null uploader
 * @property Model|null storer
 *
 * @see /database/migrations/2024_01_20_152805_create_updated_files_tables.php
 */
class UploadedFile extends Model
{
    use SoftDeletes;

    protected $casts = [
        'forcePublic' => 'boolean',
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
        if ($this->forcePublic) {
            return true;
        }

        /** @var $storer HasFileRelationInterface */
        if (($storer = $this->storer()->first()) instanceof HasFileRelationInterface) {
            return $storer->hasFileAccess(auth()->user());
        }

        return false;
    }

    public function isPublicStored(): bool
    {
        return str_starts_with($this->path, 'public');
    }

    public function getUrl(): string
    {
        return route('file', $this->id);
    }
}
