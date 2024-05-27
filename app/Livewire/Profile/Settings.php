<?php

namespace App\Livewire\Profile;

use App\Models\Configuration;
use App\Models\ConfigurationKey;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Settings extends Component
{
    public string $customLinkName;
    public string $customLink;

    public function mount(): void
    {
        $this->customLinkName =
            Configuration::getString(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_NAME, auth()->user(), '');
        $this->customLink =
            Configuration::getString(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK, auth()->user(), '');
    }

    #[Renderless]
    public function customNavBirthdayListBtnChanged(bool $enabled): void
    {
        Configuration::storeBool(ConfigurationKey::NAVIGATION_FAV_BIRTHDAY_LIST, $enabled, auth()->user());
    }

    #[Renderless]
    public function customNavLinkEnabledChanged(bool $enabled): void
    {
        Configuration::storeBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED, $enabled, auth()->user());
    }

    public function updatedCustomLinkName(): void
    {
        Configuration::storeString(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_NAME, $this->customLinkName, auth()->user());
    }

    public function updatedCustomLink(): void
    {
        Configuration::storeString(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK, $this->customLink, auth()->user());
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.profile.settings', [
        ]);
    }
}
