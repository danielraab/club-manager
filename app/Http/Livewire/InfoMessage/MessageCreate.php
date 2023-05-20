<?php

namespace App\Http\Livewire\InfoMessage;

use Livewire\Component;

class MessageCreate extends Component
{

    public function render()
    {
        return view('livewire.info-message.info-create')->layout('layouts.backend');
    }
}
