<?php

namespace App\Livewire\Sponsoring;

use App\Livewire\Forms\Sponsoring\PackageForm;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PackageCreate extends Component
{
    use AdOptionSelectionTrait;
    public PackageForm $packageForm;

    public string $previousUrl;

    public function mount(): void
    {
        $this->availableAdOptionArr = $this->getAdOptionArr();
        $this->previousUrl = url()->previous();
    }

    public function savePackage(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->packageForm->store();
        $this->packageForm->package->adOptions()->sync($this->selectedAdOptionArr);

        Log::info("Package created", [auth()->user(), $this->packageForm->package]);
        session()->put('message', __('The package has been successfully created.'));

        return redirect($this->previousUrl);
    }

    public function savePackageAndStay(): void
    {
        $this->packageForm->store();
        $this->packageForm->package->adOptions()->sync($this->selectedAdOptionArr);

        Log::info("Package created", [auth()->user(), $this->packageForm->package]);
        session()->flash('savedAndStayMessage', __('New package successfully created. You can create the next one now.'));
    }

    public function render()
    {
        return view('livewire.sponsoring.package-create')->layout('layouts.backend');
    }
}
