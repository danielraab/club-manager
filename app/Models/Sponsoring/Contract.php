<?php

namespace App\Models\Sponsoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string info
 * @property bool is_refused
 * @property bool is_contract_received
 * @property bool is_ad_data_received
 * @property bool is_paid
 *
 * @see database/migrations/2024_01_30_152805_create_sponsoring_tables.php
 */
class Contract extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "sponsor_contracts";

    protected $fillable = [
        'info',
        'is_refused',
        'is_contract_received',
        'is_ad_data_received',
        'is_paid',
    ];

    protected $casts = [
        'is_refused' => 'bool',
        'is_contract_received' => 'bool',
        'is_ad_data_received' => 'bool',
        'is_paid' => 'bool',
    ];
}
