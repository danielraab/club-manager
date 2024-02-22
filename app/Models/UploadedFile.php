<?php

namespace App\Models;

use App\Models\Sponsoring\Backer;
use App\Models\Sponsoring\Contract;
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
 * @property int uploader_id
 *
 * @see /database/migrations/2024_01_20_152805_create_updated_files_tables.php
 */
class UploadedFile extends Model
{
    use SoftDeletes;

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
        /** @var User $user */
        $user = auth()->user();
        return match ($this->storer()->first()->getMorphClass()) {
            Backer::class, Contract::class =>
            !!$user?->hasPermission(Contract::SPONSORING_SHOW_PERMISSION, Contract::SPONSORING_EDIT_PERMISSION),
            default => false
        };
    }

    public function getUrl(): string
    {
        if (str_starts_with($this->path, "public")) {
            return Storage::url($this->path);
        }

        return route("file", $this->id);
    }
}
