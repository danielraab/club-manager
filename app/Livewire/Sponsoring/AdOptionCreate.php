<?php

namespace App\Livewire\Sponsoring;

use App\Livewire\Forms\Sponsoring\AdOptionForm;
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
        session()->put('message', __('The ad option has been successfully created.'));

        return redirect($this->previousUrl);
    }

    public function saveAdOptionAndStay(): void
    {
        $this->adOptionForm->store();
        Log::info("Ad option created", [auth()->user(), $this->adOptionForm->adOption]);
        session()->flash('savedAndStayMessage', __('New ad option successfully created. You can create the next one now.'));
    }

    public function render()
    {
        return view('livewire.sponsoring.ad-option-create-edit', ["editMode" => false])->layout('layouts.backend');
    }
}
