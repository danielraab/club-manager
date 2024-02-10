<?php

namespace App\Models\Sponsoring;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property bool enabled
 * @property string name
 * @property string contact_person
 * @property string phone
 * @property string email
 * @property string street
 * @property string zip
 * @property string city
 * @property string info
 * @property \DateTime closed_at
 *
 * @see database/migrations/2024_01_30_152805_create_sponsoring_tables.php
 */
class Backer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "sponsor_backers";

    protected $fillable = [
        'enabled',
        'name',
        'contact_person',
        'phone',
        'email',
        'street',
        'zip',
        'city',
        'info',
        'closed_at',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'closed_at' => 'datetime',
    ];


    public static function allActive(): Builder
    {
        return self::query()
            ->whereNull('closed_at')
            ->where('enabled', true)
            ->orderBy('name');
    }
}
