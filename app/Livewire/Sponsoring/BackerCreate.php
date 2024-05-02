<?php

namespace App\Livewire\Sponsoring;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\Sponsoring\BackerForm;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class BackerCreate extends Component
{
    public BackerForm $backerForm;

    public string $previousUrl;

    public function mount(): void
    {
        $this->previousUrl = url()->previous();
    }

    public function saveBacker(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->backerForm->store();

        Log::info('Backer created', [auth()->user(), $this->backerForm->backer]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The backer has been successfully created.'), ItemType::SUCCESS));

        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.sponsoring.backer-create')->layout('layouts.backend');
    }
}
