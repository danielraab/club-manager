<?php

namespace App\Models\Sponsoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property bool enabled
 * @property string title
 * @property string description
 * @property float price
 *
 * @see database/migrations/2024_01_30_152805_create_sponsoring_tables.php
 */
class AdOption extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "sponsor_ad_options";

    protected $fillable = [
        'enabled',
        'title',
        'description',
        'price',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'price' => 'float',
    ];

    public static function allActive(): \Illuminate\Database\Eloquent\Builder
    {
        return self::query()
            ->where("enabled", true)
            ->orderBy("title");
    }
}
