<?php

namespace App\Livewire\Sponsoring;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\Sponsoring\AdOptionForm;
use App\Models\Sponsoring\AdOption;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AdOptionEdit extends Component
{
    public AdOptionForm $adOptionForm;

    public string $previousUrl;

    public function mount(AdOption $adOption): void
    {
        $this->adOptionForm->setAdOptionModel($adOption);
        $this->previousUrl = url()->previous();
    }

    public function saveAdOption(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->adOptionForm->update();

        Log::info('Ad option updated', [auth()->user(), $this->adOptionForm->adOption]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The ad option has been successfully updated.'), ItemType::SUCCESS));

        return redirect($this->previousUrl);
    }

    public function deleteAdOption(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->adOptionForm->delete();

        Log::info('Ad option deleted', [auth()->user(), $this->adOptionForm->adOption]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The ad option has been successfully deleted.'), ItemType::WARNING));

        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.sponsoring.ad-option-create-edit', ['editMode' => true])->layout('layouts.backend');
    }
}
