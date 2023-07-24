<?php

namespace App\Http\Livewire;

trait MemberFilterTrait
{
    public bool $filterShowBeforeEntrance = false;
    public bool $filterShowAfterRetired = false;
    public bool $filterShowPaused = false;
}
