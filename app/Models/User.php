<?php

namespace App\Models;

use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\WelcomeNotification\ReceivesWelcomeNotification;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use ReceivesWelcomeNotification;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
    ];

    public function register()
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

    public function hasPermission(string $permission): bool
    {
        return $this->userPermissions()->whereIn('id', [$permission, UserPermission::ADMIN_USER])->exists();
    }

    public function getNameWithMail()
    {
        return $this->name . " <".$this->email.">";
    }
}
