<?php

namespace App\Models;

class EventFilter
{
    public bool $inclPast;
    public bool $inclDisabled;
    public bool $inclLoggedInOnly;


    /**
     * @param bool $inclPast
     * @param bool $inclDisabled
     * @param bool $inclLoggedInOnly
     */
    public function __construct(bool $inclPast = false, bool $inclDisabled = false, bool $inclLoggedInOnly = true)
    {
        $this->inclPast = $inclPast;
        $this->inclDisabled = $inclDisabled;
        $this->inclLoggedInOnly = $inclLoggedInOnly;
    }


}
