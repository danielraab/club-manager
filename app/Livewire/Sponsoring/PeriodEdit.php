<?php

namespace App\Livewire\Sponsoring;

use App\Livewire\Forms\Sponsoring\PeriodForm;
use App\Models\Sponsoring\Period;
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
        $this->selectedPackageArr = $period->packages()->get(["id"])->pluck("id")->toArray();

        $this->periodForm->setPeriodModel($period);
        $this->previousUrl = url()->previous();
    }

    public function savePeriod(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->periodForm->update();
        $this->periodForm->period->packages()->sync($this->selectedPackageArr);

        Log::info("Period updated", [auth()->user(), $this->periodForm->period]);
        session()->put('message', __('The period has been successfully updated.'));

        return redirect($this->previousUrl);
    }

    public function deletePeriod(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->periodForm->delete();

        Log::info("Period deleted", [auth()->user(), $this->periodForm->period]);
        session()->put('message', __('The period has been successfully deleted.'));

        return redirect($this->previousUrl);
    }


    public function render()
    {
        return view('livewire.sponsoring.period-edit')->layout('layouts.backend');
    }
}
