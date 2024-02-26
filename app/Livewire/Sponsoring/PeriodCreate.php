<?php

namespace App\Livewire\Sponsoring;

use App\Livewire\Forms\Sponsoring\PeriodForm;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PeriodCreate extends Component
{
    use PackageSelectionTrait;

    public PeriodForm $periodForm;

    public string $previousUrl;

    public function mount(): void
    {
        $this->availablePackageArr = $this->getPackageArr();
        $this->previousUrl = url()->previous();
    }

    public function savePeriod(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->periodForm->store();
        $this->periodForm->period->packages()->sync($this->selectedPackageArr);

        Log::info("Period created", [auth()->user(), $this->periodForm->period]);
        session()->put('message', __('The period has been successfully created.'));

        return redirect($this->previousUrl);
    }

    public function savePeriodAndStay(): void
    {
        $this->periodForm->store();
        $this->periodForm->period->packages()->sync($this->selectedPackageArr);

        Log::info("Period created", [auth()->user(), $this->periodForm->period]);
        session()->flash('savedAndStayMessage', __('New period successfully created. You can create the next one now.'));
    }

    public function render()
    {
        return view('livewire.sponsoring.period-create')->layout('layouts.backend');
    }
}
