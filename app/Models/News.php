<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const NEWS_EDIT_PERMISSION = 'newsEdit';

    protected $fillable = [
        'title',
        'content',
    ];

    protected $casts = [
        'display_until' => 'datetime',
        'enabled' => 'boolean',
        'logged_in_only' => 'boolean'
    ];

    public function creator():BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function lastUpdater():BelongsTo {
        return $this->belongsTo(User::class);
    }
}
