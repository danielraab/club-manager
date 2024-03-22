<x-slot name="headline">
    <div class="flex gap-3 items-center">
        <a href="{{route("event.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Create new event") }}
    </div>
</x-slot>

<div x-init="$store.notificationMessages
            .addNotificationMessages(
            JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex justify-end gap-2 items-center">
        <x-button-dropdown>
            <x-slot name="mainButton">
                <button type="button" class="btn-success p-2 inline-flex items-center text-xs gap-2" wire:click="saveEvent"
                        title="Create new event"><i class="fa-solid fa-plus"></i> {{ __('Create') }}</button>
            </x-slot>

        <button type="button" class="btn-info p-2 text-xs"
                wire:click="saveEventAndStay"
                title="Create new event and stay on this site to create a second event.">{{ __('Create and stay') }}</button>
        </x-button-dropdown>
    </div>


    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.events.event-content/>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.events.event-settings/>
        </div>
    </div>

</div>
