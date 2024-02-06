<?php

namespace App\Livewire\Settings;

use App\Models\Configuration;
use App\Models\ConfigurationKey;
use App\Models\User;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Events extends Component
{
    public bool $eventStartToday = false;
    public string $eventStartDate;
    public string $eventEndDate;

    public function mount(): void
    {
        $this->eventStartToday = (bool)Configuration::getBool(ConfigurationKey::EVENT_FILTER_DEFAULT_START_TODAY);
        $this->eventStartDate = Configuration::getString(
            ConfigurationKey::EVENT_FILTER_DEFAULT_START_DATE) ?: "";
        $this->eventEndDate = Configuration::getString(
            ConfigurationKey::EVENT_FILTER_DEFAULT_END_DATE) ?: "";
    }

    #[Renderless]
    public function updatedEventStartToday(bool $value):void {
        Configuration::storeBool(
            ConfigurationKey::EVENT_FILTER_DEFAULT_START_TODAY, $value);
    }

    #[Renderless]
    public function updatedEventStartDate(string $value): void
    {
        Configuration::storeString(
            ConfigurationKey::EVENT_FILTER_DEFAULT_START_DATE, $value);
    }

    #[Renderless]
    public function updatedEventEndDate(string $value): void
    {
        Configuration::storeString(
            ConfigurationKey::EVENT_FILTER_DEFAULT_END_DATE, $value);

    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.settings.events');
    }
}
