<?php

namespace App\Livewire\Sponsoring;

use App\Facade\NotificationMessage;
use App\Models\Member;
use App\Models\Sponsoring\Backer;
use App\Models\Sponsoring\Contract;
use App\Models\Sponsoring\Period;
use Livewire\Component;

class QuickBackerAdd extends Component
{
    public ?Period $period;

    public string $name;

    public string $country;

    public string $city;

    public string $zip;

    public string $member_id;

    public function mount(?Period $period): void
    {
        $this->period = $period;
        $this->country = config('app.country_code_default');
    }

    public function customReset(): void
    {
        $this->resetExcept('period');
        $this->country = config('app.country_code_default');
    }

    public function addNewBacker(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:2'],
            'city' => ['nullable', 'string', 'max:255'],
            'zip' => ['nullable', 'integer'],
        ]);

        $isContractCreated = false;
        /** @var Backer $backer */
        /** @var Member $member */
        $backer = Backer::query()->create($validated);
        if($this->period && $this->member_id && $member = Member::find($this->member_id)) {

            $contract = new Contract();
            $contract->backer()->associate($backer);
            $contract->period()->associate($this->period);
            $contract->member()->associate($member);
            $contract->save();
            $isContractCreated = true;
        }
        $this->customReset();

        $message = __('A new backer was successfully created.');
        if($isContractCreated) {
            $message .= ' '. __('And a contract with the given member was added.');
        }
        NotificationMessage::addSuccessNotificationMessage($message);

        $this->dispatch('member-contract-has-changed');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.sponsoring.quick-backer-add');
    }
}
