<?php

namespace App\Livewire\Members;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\MemberGroupForm;
use App\Models\MemberGroup;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MemberGroupEdit extends Component
{
    public MemberGroupForm $memberGroupForm;

    public string $previousUrl;

    public function mount(MemberGroup $memberGroup): void
    {
        $this->memberGroupForm->setModel($memberGroup);
        $this->previousUrl = url()->previous();
    }

    public function saveMemberGroup()
    {
        $this->memberGroupForm->update();

        Log::info("Member group updated", [auth()->user(), $this->memberGroupForm->memberGroup]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The member group has been successfully updated.'), ItemType::SUCCESS));

        return redirect($this->previousUrl);
    }

    public function deleteMemberGroup()
    {
        $this->memberGroupForm->delete();

        Log::info("Member group deleted", [auth()->user(), $this->memberGroupForm->memberGroup]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The member group has been successfully deleted.'), ItemType::WARNING));

        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.members.member-group-edit')->layout('layouts.backend');
    }
}
