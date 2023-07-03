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

    public const MAX_CHILD_TREE_DEPTH = 6;

    protected $fillable = [
        'title',
        'description',
        'sort_order',
    ];

    public static function getTopLevelQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return self::query()->whereNull('parent_id')->orderBy('sort_order')->orderBy('title');
    }

    public static function getLeafQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return self::query()->whereDoesntHave('children')->orderBy('sort_order')->orderBy('title');
    }

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

    public function getAllChildrenRecursive(array &$childList = [], $depth = 0): array
    {
        $childList[] = $this;
        if ($depth >= self::MAX_CHILD_TREE_DEPTH) {
            return $childList;
        }

        foreach ($this->children()->get() as $child) {
            $child->getAllChildrenRecursive($childList, $depth + 1);
        }

        return $childList;
    }
}
