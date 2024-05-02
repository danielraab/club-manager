<?php

namespace App\Models\Sponsoring;

use App\Models\HasFileRelationInterface;
use App\Models\UploadedFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property bool enabled
 * @property string name
 * @property string contact_person
 * @property string phone
 * @property string email
 * @property string website
 * @property string street
 * @property string zip
 * @property string city
 * @property string country
 * @property string vat
 * @property string info
 * @property \DateTime closed_at
 * @property UploadedFile[] uploadedFiles
 *
 * @see database/migrations/2024_01_30_152805_create_sponsoring_tables.php
 */
class Backer extends Model implements HasFileRelationInterface
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'sponsor_backers';

    protected $fillable = [
        'enabled',
        'name',
        'contact_person',
        'phone',
        'email',
        'website',
        'street',
        'zip',
        'city',
        'country',
        'vat',
        'info',
        'closed_at',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'closed_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        self::deleting(function (Backer $backer) {
            foreach ($backer->uploadedFiles as $file) {
                $file->delete();
            }
        });
    }

    public static function allActive(): Builder
    {
        return self::query()
            ->whereNull('closed_at')
            ->where('enabled', true)
            ->orderBy('name');
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
