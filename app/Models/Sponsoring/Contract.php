<?php

namespace App\Models\Sponsoring;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string info
 * @property \DateTime refused
 * @property \DateTime contract_received
 * @property \DateTime ad_data_received
 * @property \DateTime paid
 *
 * @see database/migrations/2024_01_30_152805_create_sponsoring_tables.php
 */
class Contract extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const SPONSORING_EDIT_PERMISSION = 'sponsoringEdit';

    protected $table = "sponsor_contracts";

    protected $fillable = [
        'info',
        'refused',
        'contract_received',
        'ad_data_received',
        'paid',
    ];

    protected $casts = [
        'refused' => 'datetime',
        'contract_received' => 'datetime',
        'ad_data_received' => 'datetime',
        'paid' => 'datetime',
    ];

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function backer(): BelongsTo
    {
        return $this->belongsTo(Backer::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
