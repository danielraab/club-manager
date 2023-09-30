<?php

namespace App\Http\Livewire;

use App\Models\Event;
use App\Models\EventFilter;
use Illuminate\Support\Facades\Auth;

trait EventFilterTrait
{
    public bool $showPast = false;
    public bool $showDisabled = false;
    public bool $showLoggedInOnly = true;

    public function canFilterShowPast(): bool
    {
        return true;
    }

    public function canFilterShowDisabled(): bool
    {
        return Auth::user()?->hasPermission(Event::EVENT_EDIT_PERMISSION) ?: false;
    }

    public function canFilterShowLoggedInOnly(): bool
    {
        return Auth::check();
    }

    public function getEventFilter(): EventFilter
    {
        return new EventFilter(
            $this->canFilterShowPast() ? $this->showPast : false,
            $this->canFilterShowDisabled() ? $this->showDisabled : false,
            $this->canFilterShowLoggedInOnly() ? $this->showLoggedInOnly : false);
    }
}
