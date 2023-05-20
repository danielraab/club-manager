<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory;

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
