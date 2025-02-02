<?php

namespace App\Models\Sponsoring;

use App\Models\HasFileRelationInterface;
use App\Models\UploadedFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string title
 * @property string description
 * @property \DateTime start
 * @property \DateTime end
 * @property Contract[] contracts
 * @property UploadedFile[] uploadedFiles
 *
 * @see database/migrations/2024_01_30_152805_create_sponsoring_tables.php
 */
class Period extends Model implements HasFileRelationInterface
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'sponsor_periods';

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

    protected static function boot(): void
    {
        parent::boot();

        self::deleting(function (Period $period) {
            foreach ($period->contracts as $contract) {
                $contract->delete();
            }
            foreach ($period->uploadedFiles as $file) {
                $file->delete();
            }
        });

        self::forceDeleting(function (Period $period) {
            foreach ($period->contracts as $contract) {
                $contract->forceDelete();
            }
            foreach ($period->uploadedFiles as $file) {
                $file->delete();    // files stay soft deleted (as backup)
            }
        });
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'sponsor_period_sponsor_package');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function uploadedFiles(): MorphMany
    {
        return $this->morphMany(UploadedFile::class, 'storer');
    }

    public function hasFileAccess(?User $user): bool
    {
        return (bool) $user?->hasPermission(Contract::SPONSORING_SHOW_PERMISSION, Contract::SPONSORING_EDIT_PERMISSION);
    }
}
