<?php

namespace App\Livewire\Forms\Sponsoring;

use App\Models\Sponsoring\Contract;
use Carbon\Carbon;
use Livewire\Attributes\Rule;
use Livewire\Form;

class ContractForm extends Form
{
    public ?Contract $contract = null;

    #[Rule('nullable|max:255')]
    public ?string $info;

    #[Rule('nullable|numeric')]
    public ?int $member_id;

    #[Rule('nullable|numeric')]
    public ?int $package_id;

    #[Rule('nullable|date')]
    public ?string $refused = null;

    #[Rule('nullable|date')]
    public ?string $contract_received = null;

    #[Rule('nullable|date')]
    public ?string $ad_data_received = null;

    #[Rule('nullable|date')]
    public ?string $paid = null;


    public function setContractModel(Contract $contract): void
    {
        $this->contract = $contract;

        $this->info = $contract->info;
        $this->member_id = $this->contract->member_id;
        $this->package_id = $this->contract->package_id;
        $this->refused = $contract->refused?->formatDateInput();
        $this->contract_received = $contract->contract_received?->formatDateInput();
        $this->ad_data_received = $contract->ad_data_received?->formatDateInput();
        $this->paid = $contract->paid?->formatDateInput();
    }

    public function update(): void
    {
        $this->validate();

        $this->contract->update([
            ...$this->except([
                'contract',
                'refused',
                'contract_received',
                'ad_data_received',
                'paid'
            ]),
            'refused' => $this->refused ? Carbon::parseFromDatetimeLocalInput($this->refused) : null,
            'contract_received' => $this->contract_received ?
                Carbon::parseFromDatetimeLocalInput($this->contract_received) : null,
            'ad_data_received' => $this->ad_data_received ?
                Carbon::parseFromDatetimeLocalInput($this->ad_data_received) : null,
            'paid' => $this->paid ? Carbon::parseFromDatetimeLocalInput($this->paid) : null,
        ]);

        $this->contract->save();
    }

    public function delete(): void
    {
        $this->contract?->delete();
    }
}
