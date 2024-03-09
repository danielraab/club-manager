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
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 gap-2 items-center">
        <div class="flex justify-between">
            <div class="flex items-center gap-2">
                <x-default-button
                    x-data="{ clickCnt: 0, onClick() {
                        if(this.clickCnt > 0) {
                            $wire.deleteMember();
                        } else {
                            this.clickCnt++;
                            $el.innerHTML = 'Are you sure?';
                        }
                    }}"
                    x-on:click="onClick()" title="Delete this member"
                    class="btn-danger">{{ __('Delete member') }}</x-default-button>
                @if($hasUserEditPermission && $memberForm?->member?->email)
                    <x-default-button class="btn-secondary"
                                      wire:click="createUser">{{__("Create user")}}</x-default-button>
                @endif
            </div>
            <x-default-button class="btn-primary" wire:click="saveMember"
                              title="Create new member">{{ __('Save') }}</x-default-button>
        </div>
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
