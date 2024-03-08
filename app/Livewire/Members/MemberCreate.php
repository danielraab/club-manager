<?php

namespace App\Livewire\Members;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\MemberForm;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MemberCreate extends Component
{
    public MemberForm $memberForm;

    public string $previousUrl;

    public function mount(): void
    {
        $this->memberForm->paused = false;
        $this->memberForm->entrance_date = now()->format('Y-m-d');
        $this->previousUrl = url()->previous();
    }

    public function saveMember()
    {
        $this->memberForm->store();

        Log::info("Member created", [auth()->user(), $this->memberForm->member]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The member has been successfully created.'), ItemType::SUCCESS));

        return redirect($this->previousUrl);
    }

    public function saveMemberAndStay(): void
    {
        $this->memberForm->store();
        Log::info("Member created", [auth()->user(), $this->memberForm->member]);
        session()->flash('savedAndStayMessage', __('New member successfully created. You can create the next one now.'));
    }

    public function render()
    {
        return view('livewire.members.member-create')->layout('layouts.backend');
    }
}
