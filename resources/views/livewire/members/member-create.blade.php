<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Add new member") }}
    </div>
</x-slot>

<div x-init="$store.notificationMessages
            .addNotificationMessages(
            JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex justify-end gap-2 items-center">
        <button type="button" class="btn btn-success" wire:click="saveMember"
                title="Create new member"><i class="fa-solid fa-plus mr-2"></i> {{ __('Create') }}</button>
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
