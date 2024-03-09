<?php

namespace App\Livewire\Sponsoring;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\Sponsoring\AdOptionForm;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AdOptionCreate extends Component
{
    public AdOptionForm $adOptionForm;

    public string $previousUrl;

    public function mount(): void
    {
        $this->previousUrl = url()->previous();
    }

    public function saveAdOption(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->adOptionForm->store();

        Log::info("Ad option created", [auth()->user(), $this->adOptionForm->adOption]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The ad option has been successfully created.'), ItemType::SUCCESS));

        return redirect($this->previousUrl);
    }

    public function saveAdOptionAndStay(): void
    {
        $this->adOptionForm->store();
        Log::info("Ad option created", [auth()->user(), $this->adOptionForm->adOption]);
        NotificationMessage::addNotificationMessage(
            new Item(__('New ad option successfully created. You can create the next one now.'), ItemType::SUCCESS));
    }

    public function render()
    {
        return view('livewire.sponsoring.ad-option-create-edit', ["editMode" => false])->layout('layouts.backend');
    }
}
