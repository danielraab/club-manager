<?php

namespace App\Models;

class EventFilter
{
    public bool $sortAsc;

    public bool $inclPast;

    public bool $inclDisabled;

    public bool $inclLoggedInOnly;

    public function __construct(bool $inclPast = false, bool $inclDisabled = false, bool $inclLoggedInOnly = false, bool $sortAsc = true)
    {
        $this->inclPast = $inclPast;
        $this->inclDisabled = $inclDisabled;
        $this->inclLoggedInOnly = $inclLoggedInOnly;
        $this->sortAsc = $sortAsc;
    }
}
