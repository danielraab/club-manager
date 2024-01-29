<?php

namespace App\Livewire\Members;

use App\Livewire\Forms\MemberForm;
use App\Models\Member;
use App\Models\User;
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

        Log::info("Member updated", [auth()->user(), $this->memberForm->member]);
        session()->put('message', __('The member has been successfully updated.'));

        return redirect($this->previousUrl);
    }

    public function deleteMember()
    {

        $this->memberForm->delete();

        Log::info("Member deleted", [auth()->user(), $this->memberForm->member]);
        session()->put('message', __('The member has been successfully deleted.'));

        return redirect($this->previousUrl);
    }

    public function createUser()
    {
        $member = $this->memberForm->member;
        if (! $member) {
            session()->flash('createUserStatus', 'error');
            session()->flash('createUserMessage', __('Not able to create a user for this memeber.'));

            return;
        }

        if (User::query()->where('email', $member->email)->exists()) {
            session()->flash('createUserStatus', 'error');
            session()->flash('createUserMessage', __('A user with the member email already exists.'));

            return;
        }

        /** @var User $user */
        $user = User::query()->create([
            'name' => $member->getFullName(),
            'email' => $member->email,
        ]);

        $user->register();

        Log::channel('userManagement')->info("User '".$user->getNameWithMail()."' has been created by '".auth()->user()?->getNameWithMail()."'");
        session()->flash('createUserStatus', 'success');
        session()->flash('createUserMessage', __("User '".$user->name."' created successfully."));
    }

    public function render()
    {
        return view('livewire.members.member-edit')->layout('layouts.backend');
    }
}
