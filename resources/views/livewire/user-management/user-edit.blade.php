<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __('Edit user') }}
    </div>
</x-slot>

<div class="space-y-4"
     x-init="$store.notificationMessages
            .addNotificationMessages(
            JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex flex-col sm:flex-row gap-2 items-center sm:justify-between">
            <div class="flex flex-wrap gap-2 justify-center items-center">
                <button type="button"
                        x-data="{ clickCnt: 0, onClick() {
                            if(this.clickCnt === 1) {
                                this.clickCnt++;
                                $wire.deleteUser();
                            } else {
                                this.clickCnt++;
                                $el.innerHTML = 'Are you sure?';
                            }
                        }}"
                        x-on:click="onClick()" title="Delete this user"
                        x-bind:disabled="clickCnt > 1"
                        class="btn btn-danger">{{ __('Delete user') }}</button>
                <button type="button"
                        x-data="{ clickCnt: 0, onClick() {
                            if(this.clickCnt === 1) {
                                this.clickCnt++;
                                $wire.sendResetLink();
                            } else {
                                this.clickCnt++;
                                $el.innerHTML = 'Are you sure?';
                            }
                        }}"
                        x-on:click="onClick()" title="Send password reset link."
                        x-bind:disabled="clickCnt > 1"
                        class="btn btn-secondary">{{ __('Send reset link') }}</button>
            </div>
            <button type="button" class="btn btn-primary" wire:click="saveUser"
                    title="Save the current changes">{{ __('Save') }}</button>
        </div>
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
