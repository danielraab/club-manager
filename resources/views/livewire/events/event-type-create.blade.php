<x-slot name="headline">
    <div class="flex gap-3 items-center">
        <a href="{{route("event.type.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Create new event type") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex flex-row-reverse">
        <button type="button" class="btn-primary" wire:click="saveEventType"
                title="Create new event type">{{ __('Save') }}</button>
    </div>


    <div class="flex justify-center">

        <x-livewire.events.event-type-content :eventTypeForm="$eventTypeForm"/>

    </div>

</div>
