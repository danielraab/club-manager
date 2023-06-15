<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberGroup extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'sort_order',
    ];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MemberGroup::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(MemberGroup::class, 'parent_id');
    }
}
