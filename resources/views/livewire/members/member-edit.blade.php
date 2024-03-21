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
        <x-button-dropdown>
            <x-slot name="mainButton">
                <button type="button" class="btn-success p-2 text-xs gap-2" wire:click="saveMember"
                        title="Update new member"><i class="fa-solid fa-floppy-disk"></i> {{ __('Save') }}</button>
            </x-slot>
            @if($hasUserEditPermission && $memberForm?->member?->email)
                <button type="button" class="btn-secondary inline-flex gap-2 text-xs p-2"
                        wire:confirm="{{__('Are you sure you want to create a new user for this member?')}}"
                        wire:click="createUser"><i class="fa-solid fa-user-plus"></i> {{__("Create user")}}</button>
            @endif
            <button type="button"
                    wire:confirm.prompt="{{__('Are you sure you want to delete the member?\n\nPlease enter \'DELETE\' to confirm.|DELETE')}}"
                    wire:click="deleteMember" title="Delete this member"
                    class="btn-danger inline-flex gap-2 text-xs p-2"><i
                    class="fa-solid fa-trash"></i> {{ __('Delete member') }}</button>
        </x-button-dropdown>
    </div>


    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.members.member-content/>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.members.member-member-group-selection :memberForm="$memberForm"/>
        </div>
    </div>

</div>
