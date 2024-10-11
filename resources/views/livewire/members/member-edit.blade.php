<?php
$hasUserEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\UserPermission::USER_MANAGEMENT_EDIT_PERMISSION);
?>
<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Edit member") }}
    </div>
</x-slot>

<div x-init="$store.notificationMessages
            .addNotificationMessages(
            JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3 p-5 flex items-center justify-end">
        <x-button-dropdown.dropdown>
            <x-slot name="mainButton">
                <x-button-dropdown.mainButton class="btn-success" wire:click="saveMember"
                                              title="Update new member"
                                              iconClass="fa-solid fa-floppy-disk">
                    {{ __('Save') }}</x-button-dropdown.mainButton>
            </x-slot>
            @if($hasUserEditPermission && $memberForm?->member?->email)
                <x-button-dropdown.button class="btn-secondary inline-flex gap-2 text-xs p-2"
                                          wire:confirm="{{__('Are you sure you want to create a new user for this member?')}}"
                                          wire:click="createUser"
                                          iconClass="fa-solid fa-user-plus"
                >
                    {{__("Create user")}}</x-button-dropdown.button>
            @endif
            <x-button-dropdown.button
                    wire:confirm.prompt="{{__('Are you sure you want to delete the member?\n\nPlease enter \'DELETE\' to confirm.|DELETE')}}"
                    wire:click="deleteMember" title="Delete this member"
                    class="btn-danger"
                    iconClass="fa-solid fa-trash">{{ __('Delete member') }}</x-button-dropdown.button>
        </x-button-dropdown.dropdown>
    </div>


    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            @include('livewire.members.partials.member-content')
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            @include('livewire.members.partials.member-member-group-selection')
        </div>
    </div>

</div>
