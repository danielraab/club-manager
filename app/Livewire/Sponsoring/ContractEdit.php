<?php

namespace App\Livewire\Sponsoring;

use App\Livewire\Forms\Sponsoring\ContractForm;
use App\Models\Sponsoring\Contract;
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
        session()->put('message', __('The contract has been successfully updated.'));

        return redirect($this->previousUrl);
    }

    public function deleteContract(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->contractForm->delete();

        Log::info("Contract deleted", [auth()->user(), $this->contractForm->contract]);
        session()->put('message', __('The contract has been successfully deleted.'));

        return redirect($this->previousUrl);
    }


    public function render()
    {
        return view('livewire.sponsoring.contract-edit')->layout('layouts.backend');
    }
}
