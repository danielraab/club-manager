<?php

namespace App\Models\Sponsoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string title
 * @property string description
 * @property \DateTime start
 * @property \DateTime end
 *
 * @see database/migrations/2024_01_30_152805_create_sponsoring_tables.php
 */
class Period extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "sponsor_periods";

    protected $fillable = [
        'title',
        'description',
        'start',
        'end',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];
}
