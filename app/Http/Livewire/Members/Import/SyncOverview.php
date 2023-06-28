<?php

namespace App\Http\Livewire\Members\Import;

use Livewire\Component;

class SyncOverview extends Component
{
    public array $keyedData = [];

    public array $syncMap = [];

    public function mount() {
        $this->syncMap = $this->keyedData;
    }

    public function syncMembers() {
    }

    public function render()
    {
        return view('livewire.members.import.sync-overview');
    }
}
