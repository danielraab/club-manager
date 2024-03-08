<?php

namespace App\Livewire\Sponsoring;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\Sponsoring\ContractForm;
use App\Models\Sponsoring\Contract;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ContractEdit extends Component
{
    public ContractForm $contractForm;

    public string $previousUrl;

    public function mount(Contract $contract): void
    {
        $this->contractForm->setContractModel($contract);
        $this->previousUrl = url()->previous();
    }

    public function saveContract(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->contractForm->update();

        Log::info("Contract updated", [auth()->user(), $this->contractForm->contract]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The contract has been successfully updated.'), ItemType::SUCCESS));

        return redirect($this->previousUrl);
    }

    public function deleteContract(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->contractForm->delete();

        Log::info("Contract deleted", [auth()->user(), $this->contractForm->contract]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The contract has been successfully deleted.'), ItemType::WARNING));

        return redirect($this->previousUrl);
    }


    public function render()
    {
        return view('livewire.sponsoring.contract-edit')->layout('layouts.backend');
    }
}
