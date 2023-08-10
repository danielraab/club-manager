<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string title
 * @property string|null description
 * @property int sort_order
 * @see /database/migrations/2023_06_12_204229_create_member_base_table.php
 */
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

    public function filteredMembers(MemberFilter $filter): Builder
    {
        $selection = Member::addFilterToBuilder($this->members()->getQuery(), $filter);

        $selection->orderBy('lastname')->orderBy('firstname');

        return $selection;
    }

    public function getRecursiveMembers(MemberFilter $filter): Collection {
        $collection = new Collection();
        $members = $this->filteredMembers($filter)->get();
        $collection = $collection->merge($members);
        foreach($this->children()->get() as $child) {
            /** @var $child MemberGroup */
            $collection = $collection->merge($child->getRecursiveMembers($filter));
        }
        return $collection;
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
