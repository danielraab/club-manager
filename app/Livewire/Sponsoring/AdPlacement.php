<?php

namespace App\Livewire\Sponsoring;

use Livewire\Attributes\On;
use Livewire\Component;

class AdPlacement extends Component
{
    public bool $showModal = false;

    #[On('update-modal-and-show')]
    public function updateModal(int $contractId, int $adOptionId)
    {
        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.sponsoring.ad-placement');
    }
}
