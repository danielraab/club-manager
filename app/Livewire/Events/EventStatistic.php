<?php

namespace App\Livewire\Events;

use App\Livewire\EventFilterTrait;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class EventStatistic extends Component
{
    public ?int $selectedYear = null;


    public function render()
    {
        return view('livewire.events.event-statistic',[
            "availableYears" => [
                2012,2013,2014
            ]
        ])->layout('layouts.backend');
    }
}
