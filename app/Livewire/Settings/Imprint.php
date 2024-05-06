<?php

namespace App\Livewire\Settings;

use App\Models\Configuration;
use App\Models\ConfigurationKey;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Livewire\WithFileUploads;

class Imprint extends Component
{
    use WithFileUploads;

    public ?string $linkName;
    public ?string $imprintText;

    public function mount(): void
    {
        $this->linkName = Configuration::getString(ConfigurationKey::IMPRINT_LINK_NAME);
        $this->imprintText = Configuration::getString(ConfigurationKey::IMPRINT_TEXT);
    }

    #[Renderless]
    public function updatedLinkName(string $value): void
    {
        Configuration::storeString(
            ConfigurationKey::IMPRINT_LINK_NAME, $value);
    }

    #[Renderless]
    public function updatedImprintText(string $value): void
    {
        Configuration::storeString(
            ConfigurationKey::IMPRINT_TEXT, $value);
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.settings.imprint');
    }
}
