<?php

namespace App\Livewire\Sponsoring;

use App\Models\Import\ImportedMember;
use App\Models\Sponsoring\Backer;
use Livewire\Component;

class BackerOverviewItem extends Component
{
    public Backer $backer;
    public bool $showDetails;

    public function mount(Backer $backer): void
    {
        $this->backer = $backer;
    }

    public function render()
    {
        return view('components.livewire.sponsoring.overview-item', [
        ]);
    }
}
