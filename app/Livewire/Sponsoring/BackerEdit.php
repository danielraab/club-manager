<?php

namespace App\Livewire\Sponsoring;

use App\Livewire\Forms\Sponsoring\BackerForm;
use App\Models\Sponsoring\Backer;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class BackerEdit extends Component
{
    use WithFileUploads;

    public BackerForm $backerForm;

    public string $previousUrl;

    /**
     * @var TemporaryUploadedFile[]
     */
    #[Validate(['adDataArr.*' => 'file|mimes:png,jpg,pdf|max:1024'])]
    public array $adDataArr = [];

    public function mount(Backer $backer): void
    {

        $this->backerForm->setBackerModel($backer);
        $this->previousUrl = url()->previous();
    }

    public function saveBacker(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->validate();
        foreach($this->adDataArr as $adData) {
            $adData->store("path"); //TODO
        }

        $this->backerForm->update();

        Log::info("Backer updated", [auth()->user(), $this->backerForm->backer]);
        session()->put('message', __('The backer has been successfully updated.'));

        return redirect($this->previousUrl);
    }

    public function deleteBacker(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->backerForm->delete();

        Log::info("Backer deleted", [auth()->user(), $this->backerForm->backer]);
        session()->put('message', __('The backer has been successfully deleted.'));

        return redirect($this->previousUrl);
    }


    public function render()
    {
        return view('livewire.sponsoring.backer-edit')->layout('layouts.backend');
    }
}
