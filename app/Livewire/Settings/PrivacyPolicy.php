<?php

namespace App\Livewire\Settings;

use App\Models\Configuration;
use App\Models\ConfigurationKey;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Livewire\WithFileUploads;

class PrivacyPolicy extends Component
{
    use WithFileUploads;

    public ?string $privacyPolicyText;

    public function mount(): void
    {
        $this->privacyPolicyText = Configuration::getString(ConfigurationKey::PRIVACY_POLICY_TEXT);
    }

    #[Renderless]
    public function updatedPrivacyPolicyText(string $value): void
    {
        Configuration::storeString(
            ConfigurationKey::PRIVACY_POLICY_TEXT, $value);
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.settings.privacy-policy');
    }
}
