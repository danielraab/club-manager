<?php

namespace App\Livewire\Sponsoring;

use App\Livewire\Forms\Sponsoring\PackageForm;
use App\Models\Sponsoring\Package;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PackageEdit extends Component
{
    public PackageForm $packageForm;

    public string $previousUrl;

    public function mount(Package $package): void
    {

        $this->packageForm->setPackageModel($package);
        $this->previousUrl = url()->previous();
    }

    public function savePackage(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->packageForm->update();

        Log::info("Package updated", [auth()->user(), $this->packageForm->package]);
        session()->put('message', __('The package has been successfully updated.'));

        return redirect($this->previousUrl);
    }

    public function deletePackage(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->packageForm->delete();

        Log::info("Package deleted", [auth()->user(), $this->packageForm->package]);
        session()->put('message', __('The package has been successfully deleted.'));

        return redirect($this->previousUrl);
    }


    public function render()
    {
        return view('livewire.sponsoring.package-edit')->layout('layouts.backend');
    }
}
