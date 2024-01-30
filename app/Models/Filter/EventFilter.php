<?php

namespace App\Models\Filter;

use Carbon\Carbon;

class EventFilter
{
    public bool $sortAsc;

    public bool $inclDisabled;

    public bool $inclLoggedInOnly;

    public ?Carbon $start;

    public ?Carbon $end;

    public function __construct(
        Carbon $start = null,
        Carbon $end = null,
        bool $inclDisabled = false,
        bool $inclLoggedInOnly = false,
        bool $sortAsc = true)
    {
        $this->inclDisabled = $inclDisabled;
        $this->inclLoggedInOnly = $inclLoggedInOnly;
        $this->sortAsc = $sortAsc;
        $this->start = $start;
        $this->end = $end;
    }
}
