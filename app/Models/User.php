<?php

namespace App\Models;

use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\WelcomeNotification\ReceivesWelcomeNotification;

/**
 * @property int id
 * @property string name
 * @property string email
 * @property \DateTime|null email_verified_at
 * @property string|null password
 * @property string|null remember_token
 * @see /database/migrations/2014_10_12_000000_create_users_table.php
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use ReceivesWelcomeNotification;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    public function register(): void
    {
        $this->save();

        event(new Registered($this));

        $expiresAt = now()->addWeek();
        $this->sendWelcomeNotification($expiresAt);
    }

    public function userPermissions(): BelongsToMany
    {
        return $this->belongsToMany(UserPermission::class);
    }

    public function hasPermission(string ...$permission): bool
    {
        return $this->userPermissions()->whereIn('id', [...$permission, UserPermission::ADMIN_USER_PERMISSION])->exists();
    }

    public function getNameWithMail()
    {
        return $this->name.' <'.$this->email.'>';
    }
}
