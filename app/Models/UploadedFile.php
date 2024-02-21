<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string name
 * @property string mimeType
 * @property string path
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
}
