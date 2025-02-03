<?php

namespace App\Events;

use App\Services\NewUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Queue\SerializesModels;

class Registered
{
    use SerializesModels;

    public function __construct(public readonly Authenticatable $user, public readonly NewUserProvider $creator) {}
}
