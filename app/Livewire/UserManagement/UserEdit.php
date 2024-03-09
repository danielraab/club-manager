<?php

namespace App\Livewire\UserManagement;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\UserForm;
use App\Models\User;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
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
            ->info("User " . $this->userForm->user->getNameWithMail() . " has been edited by " . auth()->user()->getNameWithMail());
        NotificationMessage::addNotificationMessage(
            new Item(__("User " . $this->userForm->user->name . " saved successfully."), ItemType::SUCCESS));

        return redirect($this->previousUrl);
    }

    public function deleteUser(): RedirectResponse|Redirector
    {
        $this->userForm->delete();

        Log::channel('userManagement')
            ->info("User " . $this->userForm->user->getNameWithMail() . " has been DELETED by " . auth()->user()->getNameWithMail());
        NotificationMessage::addNotificationMessage(
            new Item(
                __("The user " . $this->userForm->user->getNameWithMail() . " has been deleted."),
                ItemType::WARNING
            ));

        return redirect(route('userManagement.index'));
    }

    public function sendResetLink()
    {
        $email = $this->userForm->user?->email;

        $status = Password::sendResetLink([
            'email' => $email,
        ]);

        $message = new Item(__('Not able to send password reset link.'), ItemType::ERROR);

        switch ($status) {
            case Password::RESET_LINK_SENT:
                $message = new Item(__('Password reset link successfully sent.'), ItemType::SUCCESS);
                break;

            case Password::RESET_THROTTLED:
                $message = new Item(__('The reset mail was throttled.'), ItemType::WARNING);
                break;

            case Password::INVALID_USER:
                $message = new Item(__('User/Mail not found.'), ItemType::ERROR);
                break;
        }
        NotificationMessage::addNotificationMessage($message);
    }

    public function render()
    {
        return view('livewire.user-management.user-edit')->layout('layouts.backend');
    }
}
