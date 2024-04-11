<?php

namespace App\Livewire\Sponsoring;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\Sponsoring\PeriodForm;
use App\Models\Sponsoring\Period;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PeriodEdit extends Component
{
    use PackageSelectionTrait;

    public PeriodForm $periodForm;

    public string $previousUrl;

    public function mount(Period $period): void
    {
        $this->availablePackageArr = $this->getPackageArr();
        $this->selectedPackageArr = $period->packages()->get(['id'])->pluck('id')->toArray();

        $this->periodForm->setPeriodModel($period);
        $this->previousUrl = url()->previous();
    }

    public function savePeriod(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->periodForm->update();
        $this->periodForm->period->packages()->sync($this->selectedPackageArr);

        Log::info('Period updated', [auth()->user(), $this->periodForm->period]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The period has been successfully updated.'), ItemType::SUCCESS));

        return redirect($this->previousUrl);
    }

    public function deletePeriod(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->periodForm->delete();

        Log::info('Period deleted', [auth()->user(), $this->periodForm->period]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The period has been successfully deleted.'), ItemType::WARNING));

        return redirect(route('sponsoring.index'));
    }

    public function render()
    {
        return view('livewire.sponsoring.period-edit')->layout('layouts.backend');
    }
}
