<?php

namespace App\Http\Livewire;

use App\Models\EventFilter;

trait EventFilterTrait
{
    public bool $filterShowPast = false;
    public bool $filterShowDisabled = false;
    public bool $filterLoggedInOnly = true;

    public function getEventFilter(): EventFilter
    {
        return new EventFilter($this->filterShowPast, $this->filterShowDisabled, $this->filterLoggedInOnly);
    }
}
