<?php

namespace App\Livewire\Forms\Sponsoring;

use App\Models\Sponsoring\Contract;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ContractForm extends Form
{
    public ?Contract $contract = null;

    #[Validate('nullable|max:255')]
    public ?string $info;

    #[Validate('nullable|numeric')]
    public ?int $member_id = null;

    #[Validate('nullable|numeric')]
    public ?int $package_id = null;

    #[Validate('nullable|date')]
    public ?string $refused = null;

    #[Validate('nullable|date')]
    public ?string $contract_received = null;

    #[Validate('nullable|date')]
    public ?string $ad_data_received = null;

    #[Validate('nullable|date')]
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
                'member_id',
                'package_id',
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

        $this->contract->member()->associate($this->member_id <= 0 ? null : $this->member_id);
        $this->contract->package()->associate($this->package_id <= 0 ? null : $this->package_id);

        $this->contract->save();
    }

    public function delete(): void
    {
        $this->contract?->delete();
    }
}
