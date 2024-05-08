<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Filter\EventFilter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Session;

trait EventFilterTrait
{
    #[Session]
    public bool $isStartNow = true;

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
        $start = new Carbon();
        if (! $this->isStartNow) {
            $start = $this->start ? Carbon::parseFromDatetimeLocalInput($this->start) : null;
        }

        return new EventFilter(
            $start,
            $this->end ? Carbon::parseFromDatetimeLocalInput($this->end) : null,
            $this->canFilterShowDisabled() ? $this->showDisabled : false,
            $this->canFilterShowLoggedInOnly() ? $this->showLoggedInOnly : false,
            $this->sortAsc
        );
    }
}
