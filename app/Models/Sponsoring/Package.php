<?php

namespace App\Models\Sponsoring;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property bool enabled
 * @property string title
 * @property string description
 * @property bool is_official
 * @property float price
 *
 * @see database/migrations/2024_01_30_152805_create_sponsoring_tables.php
 */
class Package extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "sponsor_packages";

    protected $fillable = [
        'title',
        'description',
        'is_official',
        'price',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'is_official' => 'boolean',
        'price' => 'float',
    ];

    public function adOptions(): BelongsToMany
    {
        return $this->belongsToMany(AdOption::class, "sponsor_package_sponsor_ad_option");
    }

    public function periods(): BelongsToMany
    {
        return $this->belongsToMany(Period::class, "sponsor_period_sponsor_package");
    }

    public static function allActive(): \Illuminate\Database\Eloquent\Builder
    {
        return self::query()->where("enabled", true)
            ->orderBy("title");
    }
}
