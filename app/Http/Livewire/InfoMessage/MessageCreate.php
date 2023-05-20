<?php

namespace App\Http\Livewire\InfoMessage;

use App\Models\InfoMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class MessageCreate extends Component
{
    public InfoMessage $info;
    public string $display_until;

    protected array $rules = [
        "info.title" => ["nullable", "string", "max:255"],
        "info.content" => ["nullable", "string"],
        "info.enabled" => ["nullable", "boolean"],
        "info.logged_in_only" => ["nullable", "boolean"],
        "display_until" => ["required", "date"]
    ];

    public function mount()
    {
        $this->info = new InfoMessage();
        $this->info->enabled = true;
        $this->info->logged_in_only = false;
        $this->display_until = now()->addWeek();
    }

    /**
     * @throws ValidationException
     */
    private function additionalContentValidation(): void
    {
        if (($this->info->title === null || strlen(trim($this->info->title)) === 0) &&
            ($this->info->content === null || strlen(trim($this->info->content)) === 0)
        ) {
            $titleContentEmpty = __("One of the fields (:fields) must have content.", ["fields" => __("title") . ", " . __("content")]);
            throw ValidationException::withMessages([
                "info.title" => $titleContentEmpty,
                "info.content" => $titleContentEmpty
            ]);
        }
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
