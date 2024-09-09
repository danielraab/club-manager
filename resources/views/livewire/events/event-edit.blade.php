<x-slot name="headline">
    <div class="flex gap-3 items-center">
        <a href="{{route("event.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Update event") }}
    </div>
</x-slot>

<div x-init="$store.notificationMessages
            .addNotificationMessages(
            JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3 p-5 flex items-center justify-end">
        <x-button-dropdown>
            <x-slot name="mainButton">
                <button type="button" class="btn-success p-2 text-xs inline-flex items-center gap-2" wire:click="saveEvent"
                        title="Update event"><i class="fa-solid fa-floppy-disk"></i> {{ __('Save') }}</button>
            </x-slot>
            <button type="button" class="btn-primary inline-flex gap-2 text-xs p-2"
{{--                    wire:click="saveEventCopy"--}}
                    x-on:click.prevent="$dispatch('open-modal', 'copy-event-modal')"
                    title="Copy this event"
            ><i class="fa-solid fa-copy"></i> {{__("Copy event")}}</button>
            @if($eventForm->start > now() && $eventForm->enabled && !$eventForm->logged_in_only)
                <button type="button"
                        class="btn-info inline-flex gap-2 text-xs p-2"
                        wire:click="forceWebPush"
                        wire:confirm="{{__('Are you sure you want to send a web push to all subscribers?')}}"
                        title="Force a web push to all subscribes (with the updated data).">
                    <i class="fa-solid fa-bell"></i> {{ __('Force web push') }}</button>
            @endif
            <button type="button" class="text-xs p-2 btn-danger inline-flex gap-2"
                    wire:confirm="{{__('Are you sure you want to delete this event?')}}"
                    wire:click="deleteEvent" title="Delete this event"
            ><i class="fa-solid fa-trash"></i> {{ __('Delete event') }}</button>
        </x-button-dropdown>
    </div>

    <x-modal id="copy-event-modal" title="Copy this event" showX>
        <div class="p-3">
            <x-datepicker id="copy-event-datepicker"
                          class="max-w-96 mx-auto" wire:model="copyDateList" multiple showList/>
            <div class="flex justify-between mt-4">
                <button class="btn btn-primary" type="button" x-on:click="$dispatch('reset-date-list', 'copy-event-datepicker')">clear</button>
                <button class="btn btn-create" type="button"
                        wire:confirm="{{__('Are you sure to create new events ?')}}"
                        wire:click="copyEvent">{{__('copy event')}}</button>
            </div>
        </div>
    </x-modal>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.events.event-content :eventForm="$eventForm"/>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.events.event-settings :eventForm="$eventForm"/>
        </div>
    </div>

</div>
