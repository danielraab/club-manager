<?php

namespace App\Http\Livewire\InfoMessage;

use App\Models\InfoMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class MessageCreate extends Component
{
    use MessageTrait;

    public function mount()
    {
        $this->info = new InfoMessage();
        $this->info->enabled = true;
        $this->info->logged_in_only = false;
        $this->display_until = now()->addWeek()->format("Y-m-d\TH:00");
    }


    /**
     * @throws ValidationException
     */
    public function saveInfo()
    {
        $this->validate();
        $this->additionalContentValidation();
        $this->info->display_until = $this->display_until;

        $this->info->creator()->associate(Auth::user());
        $this->info->lastUpdater()->associate(Auth::user());

        $this->info->save();
        session()->put("message", __("Info message successfully added."));

        $this->redirect(route("infoMessage.index"));
    }

    public function render()
    {
        return view('livewire.info-message.info-create')->layout('layouts.backend');
    }
}
