<?php

namespace App\Livewire\Sponsoring;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\Sponsoring\PackageForm;
use App\Models\Sponsoring\Package;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PackageEdit extends Component
{
    use AdOptionSelectionTrait;

    public PackageForm $packageForm;

    public string $previousUrl;

    public function mount(Package $package): void
    {
        $this->availableAdOptionArr = $this->getAdOptionArr();
        $this->selectedAdOptionArr = $package->adOptions()->get(['id'])->pluck('id')->toArray();

        $this->packageForm->setPackageModel($package);
        $this->previousUrl = url()->previous();
    }

    public function savePackage(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->packageForm->update();
        $this->packageForm->package->adOptions()->sync($this->selectedAdOptionArr);

        Log::info('Package updated', [auth()->user(), $this->packageForm->package]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The package has been successfully updated.'), ItemType::SUCCESS));

        return redirect($this->previousUrl);
    }

    public function deletePackage(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->packageForm->delete();

        Log::info('Package deleted', [auth()->user(), $this->packageForm->package]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The package has been successfully deleted.'), ItemType::WARNING));

        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.sponsoring.package-edit')->layout('layouts.backend');
    }
}
