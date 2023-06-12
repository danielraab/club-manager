<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const MEMBER_EDIT_PERMISSION = 'memberEdit';
    public const MEMBER_SHOW_PERMISSION = 'memberShow';

    protected $fillable = [
        'firstname',
        'lastname',
        'birthday',
        'phone',
        'email',
        'street',
        'zip',
        'city',
        'entrance_date',
        'leaving_date',
    ];

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
