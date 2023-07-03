<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use function Deployer\select;

class Member extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const MEMBER_EDIT_PERMISSION = 'memberEdit';
    public const MEMBER_SHOW_PERMISSION = 'memberShow';

    protected $fillable = [
        'firstname',
        'lastname',
        'title_pre',
        'title_post',
        'special',
        'birthday',
        'phone',
        'email',
        'street',
        'zip',
        'city',
        'entrance_date',
        'leaving_date',
        'external_id',
        'last_import_date',
    ];

    protected $casts = [
        'special' => 'bool',
        'birthday' => 'date',
        'entrance_date' => 'datetime',
        'leaving_date' => 'datetime',
        'last_import_date' => 'datetime',
    ];

    public function getFullName(): string
    {
        $fullName = "";
        if ($this->title_pre) {
            $fullName = $this->title_pre . " ";
        }
        $fullName .= $this->lastname . " " . $this->firstname;
        if ($this->title_post) {
            $fullName .= " " . $this->title_post;
        }
        return $fullName;
    }

    public static function allActive(bool $includeSpecial = true): Builder
    {
        $selection = self::query()->where("entrance_date", "<", now());
        if(!$includeSpecial) {
            $selection->where("special", false);
        }
        $selection->where(function (Builder $query) {
                $query->whereNull("leaving_date")
                    ->orWhere("leaving_date", ">", now());
            })->orderBy("lastname")->orderBy("firstname");

        return $selection;
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lastUpdater(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function memberGroups(): BelongsToMany
    {
        return $this->belongsToMany(MemberGroup::class);
    }
}
