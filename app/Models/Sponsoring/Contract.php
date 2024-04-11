<?php

namespace App\Models\Sponsoring;

use App\Models\HasFileRelationInterface;
use App\Models\Member;
use App\Models\UploadedFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use function Deployer\upload;

/**
 * @property int id
 * @property string info
 * @property \DateTime refused
 * @property \DateTime contract_received
 * @property \DateTime ad_data_received
 * @property \DateTime paid
 * @property Member|null member
 * @property UploadedFile|null uploadedFile
 * @property Package|null package
 *
 * @see database/migrations/2024_01_30_152805_create_sponsoring_tables.php
 */
class Contract extends Model implements HasFileRelationInterface
{
    use HasFactory;
    use SoftDeletes;

    public const SPONSORING_SHOW_PERMISSION = 'sponsoringShow';

    public const SPONSORING_EDIT_PERMISSION = 'sponsoringEdit';

    protected $table = 'sponsor_contracts';

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

    protected static function boot(): void
    {
        parent::boot();

        self::deleting(function (Contract $contract) {
            $contract->uploadedFile?->delete();
        });

        self::forceDeleting(function (Contract $contract) {
            AdPlacement::query()->where('contract_id', $contract->id)->forceDelete();
            $contract->uploadedFile?->delete();    //files stay soft deleted (as backup)
        });
    }

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

    public function uploadedFile(): MorphOne
    {
        return $this->morphOne(UploadedFile::class, 'storer');
    }

    public function hasFileAccess(?User $user): bool
    {
        return (bool) $user?->hasPermission(Contract::SPONSORING_SHOW_PERMISSION, Contract::SPONSORING_EDIT_PERMISSION);
    }
}
