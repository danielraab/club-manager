<?php

namespace App\Models\Sponsoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
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
        'is_official' => 'bool',
        'price' => 'float',
    ];
}
