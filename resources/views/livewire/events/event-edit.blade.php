<x-slot name="headline">
    <div class="flex gap-3 items-center">
        <a href="{{route("event.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Update event") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3 p-5 flex items-center justify-end">
        <x-button-dropdown>
            <x-slot name="mainButton">
                <button type="button" class="btn-success p-2 text-xs inline-flex items-center gap-2" wire:click="saveEvent"
                        title="Update event"><i class="fa-solid fa-floppy-disk"></i> {{ __('Save') }}</button>
            </x-slot>
            <button type="button" class="btn-create inline-flex gap-2 text-xs p-2"
                    wire:click="saveEventCopy"
                    title="Save copy of the event"
            ><i class="fa-solid fa-copy"></i> {{__("Save copy")}}</button>
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


    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.events.event-content :eventForm="$eventForm"/>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.events.event-settings :eventForm="$eventForm"/>
        </div>
    </div>

</div>
