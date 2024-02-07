<?php

namespace App\Models\Sponsoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string title
 * @property string description
 * @property float price
 *
 * @see database/migrations/2024_01_30_152805_create_sponsoring_tables.php
 */
class AdOptions extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "sponsor_ad_options";

    protected $fillable = [
        'title',
        'description',
        'price',
    ];

    protected $casts = [
        'price' => 'float',
    ];
}
