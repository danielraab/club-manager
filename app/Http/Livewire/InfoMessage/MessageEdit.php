<?php

namespace App\Http\Livewire\InfoMessage;

use App\Models\InfoMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class MessageEdit extends Component
{
    use MessageTrait;

    public function mount(InfoMessage $message)
    {
        $this->info = $message;
        $this->display_until = $message->display_until;
    }

    public function deleteInfo()
    {
        $this->info->delete();
        session()->put("message", __("The info message has been successfully deleted."));
        $this->redirect(route("infoMessage.index"));
    }

    public function saveInfo() {
        $this->validate();
        $this->additionalContentValidation();
        $this->info->display_until = $this->display_until;

        $this->info->lastUpdater()->associate(Auth::user());

        $this->info->save();
        session()->put("message", __("Info message successfully updated."));

        $this->redirect(route("infoMessage.index"));
    }

    public function render()
    {
        return view('livewire.info-message.info-edit')->layout('layouts.backend');
    }
}
