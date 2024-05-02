<?php

namespace App\Livewire\Sponsoring;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\Sponsoring\BackerForm;
use App\Models\Sponsoring\Backer;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class BackerEdit extends Component
{
    public BackerForm $backerForm;

    public string $previousUrl;

    public function mount(Backer $backer): void
    {

        $this->backerForm->setBackerModel($backer);
        $this->previousUrl = url()->previous();
    }

    public function saveBacker(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->backerForm->update();

        Log::info('Backer updated', [auth()->user(), $this->backerForm->backer]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The backer has been successfully updated.'), ItemType::SUCCESS));

        return redirect($this->previousUrl);
    }

    public function deleteBacker(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->backerForm->delete();

        Log::info('Backer deleted', [auth()->user(), $this->backerForm->backer]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The backer has been successfully deleted.'), ItemType::WARNING));

        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.sponsoring.backer-edit')->layout('layouts.backend');
    }
}
