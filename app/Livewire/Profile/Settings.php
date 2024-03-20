<?php

namespace App\Livewire\Profile;

use App\Models\Configuration;
use App\Models\ConfigurationKey;
use App\Models\User;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Settings extends Component
{
    #[Renderless]
    public function dashboardButtonChangedBirthdayList(bool $enabled): void
    {
        Configuration::storeBool(ConfigurationKey::NAVIGATION_FAV_BIRTHDAY_LIST, $enabled, auth()->user());
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        /** @var User $user */
        $user = auth()->user();

        return view('livewire.profile.settings', [
        ]);
    }
}
