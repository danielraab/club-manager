@php
/** @var \App\Livewire\Forms\UserForm $userForm */
@endphp
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
        <x-button-dropdown.dropdown>
            <x-slot name="mainButton">
                <x-button-dropdown.mainButton class="btn-success" wire:click="saveUser"
                        title="Save the current changes" iconClass="fa-solid fa-floppy-disk">{{ __('Save') }}</x-button-dropdown.mainButton>
            </x-slot>
                <x-button-dropdown.button class="btn-secondary"
                        wire:confirm="{{__('Are you sure you want to send a password reset link to the users mail address?')}}"
                        wire:click="sendResetLink" iconClass="fa-solid fa-user-plus">{{__("Send reset link")}}</x-button-dropdown.button>
            <x-button-dropdown.button
                    wire:confirm.prompt="{{__('Are you sure you want to delete the user?\n\nPlease enter \'DELETE\' to confirm.|DELETE')}}"
                    wire:click="deleteUser" title="Delete this user"
                    class="btn-danger" iconClass="fa-solid fa-trash">{{ __('Delete user') }}</x-button-dropdown.button>
        </x-button-dropdown.dropdown>
    </div>
    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 sm:p-8 max-w-xl">
                @include('livewire.user-management.partials.user-form')
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 sm:p-8 max-w-xl">
                <div class="text-gray-500 mt-3 ml-3 space-x-2">
                    @if($userForm->user->email_verified_at)
                        <i class="fa-solid fa-at text-green-700"></i>
                        <span title="{{__("Email verified at")}}">{{$userForm->user->email_verified_at?->formatDateTimeWithSec()}}</span>
                    @else
                        <i class="fa-solid fa-at text-red-700"></i>
                        <span class="text-red-700">{{__('Email is not verified yet.')}}</span>
                    @endif
                </div>
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
            @include('livewire.user-management.partials.user-permission')
        </div>
    </div>
</div>
