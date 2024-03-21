<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __('Edit user') }}
    </div>
</x-slot>

<div class="space-y-4"
     x-init="$store.notificationMessages
            .addNotificationMessages(
            JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex justify-end items-center">
        <x-button-dropdown>
            <x-slot name="mainButton">
                <button type="button" class="btn-success p-2 text-xs gap-2" wire:click="saveUser"
                        title="Save the current changes"><i class="fa-solid fa-floppy-disk"></i> {{ __('Save') }}</button>
            </x-slot>
                <button type="button" class="btn-secondary inline-flex gap-2 text-xs p-2"
                        wire:confirm="{{__('Are you sure you want to send a password reset link to the users mail address?')}}"
                        wire:click="sendResetLink"><i class="fa-solid fa-user-plus"></i> {{__("Send reset link")}}</button>
            <button type="button"
                    wire:confirm.prompt="{{__('Are you sure you want to delete the user?\n\nPlease enter \'DELETE\' to confirm.|DELETE')}}"
                    wire:click="deleteUser" title="Delete this user"
                    class="btn-danger inline-flex gap-2 text-xs p-2"><i
                    class="fa-solid fa-trash"></i> {{ __('Delete user') }}</button>
        </x-button-dropdown>
    </div>
    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 sm:p-8 max-w-xl">
                <x-livewire.user-management.user-form/>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 sm:p-8 max-w-xl">
                <div class="text-gray-500 mt-3 ml-3 space-x-2">
                    <i class="fa-regular fa-square-plus"></i>
                    <span title="{{__("Created at")}}">{{$userForm->user->created_at?->formatDateTimeWithSec()}}</span>
                </div>
                @if($userForm->user->last_login_at)
                    <div class="text-gray-500 mt-3 ml-3 space-x-2">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span
                            title="{{__("Last login at")}}">{{$userForm->user->last_login_at?->formatDateTimeWithSec()}}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-4 sm:p-8">
            <x-livewire.user-management.user-permission/>
        </div>
    </div>
</div>
