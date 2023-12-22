<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Filter\EventFilter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait EventFilterTrait
{
    public ?string $start = null;

    public ?string $end = null;

    public bool $sortAsc = true;

    public bool $showDisabled = false;

    public bool $showLoggedInOnly = true;

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
            $this->start ? Carbon::parseFromDatetimeLocalInput($this->start) : null,
            $this->end ? Carbon::parseFromDatetimeLocalInput($this->end) : null,
            $this->canFilterShowDisabled() ? $this->showDisabled : false,
            $this->canFilterShowLoggedInOnly() ? $this->showLoggedInOnly : false,
            $this->sortAsc
        );
    }
}
