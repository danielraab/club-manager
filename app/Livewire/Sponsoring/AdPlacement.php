<?php

namespace App\Livewire\Sponsoring;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\Sponsoring\AdPlacementForm;
use App\Models\Sponsoring\AdOption;
use App\Models\Sponsoring\AdPlacement as AdPlacementModel;
use App\Models\Sponsoring\Contract;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;

class AdPlacement extends Component
{
    public ?Contract $contract;

    public ?AdOption $adOption;

    public AdPlacementForm $adPlacementForm;

    /**
     * @throws AuthenticationException
     */
    public function boot():void {
        $hasPlacementEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(
            \App\Models\Sponsoring\AdPlacement::SPONSORING_EDIT_AD_PLACEMENTS,
            \App\Models\Sponsoring\Contract::SPONSORING_EDIT_PERMISSION
        );
        if(!$hasPlacementEditPermission) {
            throw new AuthenticationException("You are not authorized");
        }
    }

    #[On('update-modal-and-show')]
    public function updateModal(Contract $contract, AdOption $adOption): void
    {
        $this->contract = $contract;
        $this->adOption = $adOption;
        $adPlacement = AdPlacementModel::find($contract->id, $adOption->id);
        if ($adPlacement === null) {
            $adPlacement = new AdPlacementModel();
            $adPlacement->done = false;
            $adPlacement->contract()->associate($contract);
            $adPlacement->adOption()->associate($adOption);
            $adPlacement->save();
        }
        $this->adPlacementForm->setAdPlacementModel($adPlacement);

        $this->dispatch('open-modal', 'adPlacement');
    }

    /**
     * @throws ValidationException
     */
    public function save(): void
    {
        $this->adPlacementForm->update();
        NotificationMessage::addNotificationMessage(
            new Item(__('The ad placement information has been successfully saved.'), ItemType::SUCCESS));

        $this->dispatch('close');
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.sponsoring.ad-placement');
    }
}
