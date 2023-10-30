<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __('Edit user') }}
    </div>
</x-slot>

<div class="space-y-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex gap-1 items-center justify-between">
            <div>
                <div class="flex flex-wrap grow-0 gap-1 justify-center">
                    <x-default-button
                        x-data="{ clickCnt: 0, onClick() {
                        if(this.clickCnt > 0) {
                            $wire.deleteUser();
                        } else {
                            this.clickCnt++;
                            $el.innerHTML = 'Are you sure?';
                        }
                    }}"
                        x-on:click="onClick()" title="Delete this user"
                        class="btn-danger">{{ __('Delete user') }}</x-default-button>
                    <x-default-button
                        x-data="{ clickCnt: 0, onClick() {
                        if(this.clickCnt > 0) {
                            $wire.sendResetLink();
                        } else {
                            this.clickCnt++;
                            $el.innerHTML = 'Are you sure?';
                        }
                    }}"
                        x-on:click="onClick()" title="Send reset link"
                        class="btn-secondary">{{ __('Send reset link') }}</x-default-button>
                </div>
            </div>
            <x-default-button class="btn-primary" wire:click="saveUser"
                              title="Save the current changes">{{ __('Save') }}</x-default-button>
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
