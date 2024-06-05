<?php

namespace App\Livewire\Members;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\MemberForm;
use App\Models\Member;
use App\Models\User;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MemberEdit extends Component
{
    public MemberForm $memberForm;

    public string $previousUrl;

    public function mount(Member $member): void
    {
        $this->memberForm->setMemberModal($member);
        $this->previousUrl = url()->previous();
    }

    public function saveMember()
    {
        $this->memberForm->update();

        Log::info('Member updated', [auth()->user(), $this->memberForm->member]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The member has been successfully updated.'), ItemType::SUCCESS));

        return redirect($this->previousUrl);
    }

    public function deleteMember()
    {

        $this->memberForm->delete();

        Log::info('Member deleted', [auth()->user(), $this->memberForm->member]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The member has been successfully deleted.'), ItemType::WARNING));

        return redirect($this->previousUrl);
    }

    public function createUser()
    {
        $member = $this->memberForm->member;
        if (! $member) {
            NotificationMessage::addNotificationMessage(
                new Item(__('Not able to create a user for this member.'), ItemType::ERROR));

            return;
        }

        if (! $member->email) {
            NotificationMessage::addNotificationMessage(
                new Item(__('Member has no email address.'), ItemType::ERROR));

            return;
        }

        if (User::query()->where('email', $member->email)->exists()) {
            NotificationMessage::addNotificationMessage(
                new Item(__('A user with the member email already exists.'), ItemType::ERROR));

            return;
        }

        /** @var User $user */
        $user = User::query()->create([
            'name' => $member->getFullName(),
            'email' => $member->email,
        ]);

        $user->register();

        Log::channel('userManagement')->info('User '.$user->getNameWithMail().' has been created by '.auth()->user()?->getNameWithMail());
        NotificationMessage::addNotificationMessage(
            new Item(__('User '.$user->name.' created successfully.'), ItemType::SUCCESS));
    }

    public function render()
    {
        return view('livewire.members.member-edit')->layout('layouts.backend');
    }
}
