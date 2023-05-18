<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserPermission extends Model
{
    use HasFactory;

    public const ADMIN_USER_PERMISSION = 'adminUser';

    public const USER_MANAGEMENT_SHOW_PERMISSION = 'userManagementShow';

    public const USER_MANAGEMENT_EDIT_PERMISSION = 'userManagementEdit';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'label',
        'is_default',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
