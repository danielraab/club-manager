<?php

namespace App\Models\Sponsoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property bool done
 * @property string comment
 * @property int contract_id
 * @property int option_id
 *
 * @see database/migrations/2024_01_30_152805_create_sponsoring_tables.php
 */
class AdPlacement extends Model
{
    use HasFactory;

    public const SPONSORING_EDIT_AD_PLACEMENTS = 'sponsoringEditAdPlacement';

    protected $table = 'sponsor_ad_placements';

    protected $fillable = [
        'done',
        'comment',
    ];

    protected $casts = [
        'done' => 'boolean',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function adOption(): BelongsTo
    {
        return $this->belongsTo(AdOption::class);
    }

    public static function find(int $contactId, int $adOptionId): \Illuminate\Database\Eloquent\Builder|Model|null
    {
        return self::query()->where('contract_id', $contactId)->where('ad_option_id', $adOptionId)->first();
    }
}
