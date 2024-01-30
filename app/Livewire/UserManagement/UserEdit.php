<?php

namespace App\Livewire\UserManagement;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class UserEdit extends Component
{
    public UserForm $userForm;

    public string $previousUrl;

    public function mount(User $user): void
    {
        $this->userForm->setUserModel($user);
        $this->previousUrl = url()->previous();
    }

    public function saveUser(): RedirectResponse|Redirector
    {
        $this->userForm->update();

        Log::channel('userManagement')
            ->info("User '".$this->userForm->user->getNameWithMail()."' has been edited by '".auth()->user()->getNameWithMail()."'");
        session()->put('message', __("User '".$this->userForm->user->name."' saved successfully."));

        return redirect($this->previousUrl);
    }

    public function deleteUser(): RedirectResponse|Redirector
    {
        $this->userForm->delete();

        Log::channel('userManagement')
            ->info("User '".$this->userForm->user->getNameWithMail()."' has been DELETED by '".auth()->user()->getNameWithMail()."'");
        session()->put('message', __("The user '".$this->userForm->user->getNameWithMail()."' has been deleted."));

        return redirect(route('userManagement.index'));
    }

    public function sendResetLink()
    {
        $email = $this->userForm->user?->email;

        $status = Password::sendResetLink([
            'email' => $email,
        ]);

        switch ($status) {
            case Password::RESET_LINK_SENT:
                session()->flash('sendResetLinkMessage', __('Password reset link successfully sent.'));

                return;

            case Password::RESET_THROTTLED:
                session()->flash('sendResetLinkMessage', __('The reset mail was throttled.'));

                return;

            case Password::INVALID_USER:
                session()->flash('sendResetLinkMessage', __('User/Mail not found.'));

                return;

            default:
                session()->flash('sendResetLinkMessage', __('Not able to send password reset link.'));
        }

    }

    public function render()
    {
        return view('livewire.user-management.user-edit')->layout('layouts.backend');
    }
}
