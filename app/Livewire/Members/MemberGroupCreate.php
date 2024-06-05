<?php

namespace App\Livewire\Members;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\MemberGroupForm;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MemberGroupCreate extends Component
{
    public MemberGroupForm $memberGroupForm;

    public string $previousUrl;

    public function mount(): void
    {
        $this->previousUrl = url()->previous();
    }

    public function saveMemberGroup()
    {
        $this->memberGroupForm->store();

        Log::info('Member group created', [auth()->user(), $this->memberGroupForm->memberGroup]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The member group has been successfully created.'), ItemType::SUCCESS));

        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.members.member-group-create')->layout('layouts.backend');
    }
}
