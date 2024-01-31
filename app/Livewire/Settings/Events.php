<?php

namespace App\Livewire\Settings;

use App\Models\Configuration;
use App\Models\ConfigurationKey;
use App\Models\User;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Events extends Component
{
    public string $eventStartDate;
    public string $eventEndDate;

    public function mount()
    {
        $this->eventStartDate = \App\Models\Configuration::getString(
            \App\Models\ConfigurationKey::EVENT_FILTER_DEFAULT_START_DATE) ?: "";
        $this->eventEndDate = \App\Models\Configuration::getString(
            \App\Models\ConfigurationKey::EVENT_FILTER_DEFAULT_END_DATE) ?: "";
    }


    #[Renderless]
    public function updatedEventStartDate(string $value)
    {
        \App\Models\Configuration::storeString(
            ConfigurationKey::EVENT_FILTER_DEFAULT_START_DATE, $value);

    }

    #[Renderless]
    public function updatedEventEndDate(string $value)
    {
        \App\Models\Configuration::storeString(
            ConfigurationKey::EVENT_FILTER_DEFAULT_END_DATE, $value);

    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.settings.events');
    }
}
