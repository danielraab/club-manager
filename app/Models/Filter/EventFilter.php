<?php

namespace App\Models\Filter;

use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class EventFilter
{
    public const PARAM_INCL_DISABLED = 'disabled';

    public const PARAM_INCL_LOGGED_IN_ONLY = 'loggedInOnly';

    public const PARAM_START_DATE = 'start';

    public const PARAM_END_DATE = 'end';

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

    public function toParameterArray(): array
    {
        return [
            self::PARAM_START_DATE => $this->start,
            self::PARAM_END_DATE => $this->end,
            self::PARAM_INCL_DISABLED => $this->inclDisabled,
            self::PARAM_INCL_LOGGED_IN_ONLY => $this->inclLoggedInOnly,
        ];
    }

    public static function getEventFilterFromRequest(): EventFilter
    {
        return new EventFilter(
            Request::get(self::PARAM_START_DATE),
            Request::get(self::PARAM_END_DATE),
            Request::get(self::PARAM_INCL_DISABLED),
            Request::get(self::PARAM_INCL_LOGGED_IN_ONLY));
    }
}
