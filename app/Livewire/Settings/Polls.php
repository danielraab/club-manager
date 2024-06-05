<?php

namespace App\Livewire\Settings;

use App\Models\Configuration;
use App\Models\ConfigurationKey;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Polls extends Component
{
    #[Renderless]
    public function setBeforeEntrance(bool $value): void
    {
        Configuration::storeBool(ConfigurationKey::POLL_PUBLIC_FILTER_BEFORE_ENTRANCE, $value);
    }

    #[Renderless]
    public function setAfterRetired(bool $value): void
    {
        Configuration::storeBool(ConfigurationKey::POLL_PUBLIC_FILTER_AFTER_RETIRED, $value);
    }

    #[Renderless]
    public function setShowPaused(bool $value): void
    {
        Configuration::storeBool(ConfigurationKey::POLL_PUBLIC_FILTER_SHOW_PAUSED, $value);
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.settings.polls');
    }
}
