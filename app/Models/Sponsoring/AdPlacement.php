<?php

namespace App\Models\Sponsoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * todo missing visual implementation
 * @property int id
 * @property bool done
 * @property string comment
 *
 * @see database/migrations/2024_01_30_152805_create_sponsoring_tables.php
 */
class AdPlacement extends Model
{
    use HasFactory;

    public const SPONSORING_EDIT_AD_PLACEMENTS = "sponsoringEditAdPlacement";

    protected $table = "sponsor_ad_placements";

    protected $fillable = [
        'done',
        'comment',
    ];

    protected $casts = [
        'done' => 'boolean',
    ];
}
