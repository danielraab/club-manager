<x-slot name="headline">
    <div class="flex gap-3 items-center">
        <a href="{{route("event.type.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Update event type") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex items-center justify-end">
        <x-button-dropdown.dropdown>
            <x-slot name="mainButton">
                <x-button-dropdown.mainButton class="btn-success" wire:click="saveEventType"
                        title="Create new event type" iconClass="fa-solid fa-floppy-disk">
                    {{ __('Save') }}</x-button-dropdown.mainButton>
            </x-slot>
            <x-button-dropdown.button
                    class="btn-danger"
                    wire:confirm="{{__('Are you sure you want to delete this event type?')}}"
                    wire:click="deleteEventType" title="Delete this event"
                    title="Delete this event type"
                    iconClass="fa-solid fa-trash">{{ __('Delete event type') }}</x-button-dropdown.button>
        </x-button-dropdown.dropdown>

    </div>


    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <x-livewire.events.event-type-content :eventTypeForm="$eventTypeForm"/>

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Statistic') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Some event statistics.") }}
                    </p>
                </header>
                <div class="my-3">
                    <ul class="list-disc ml-4">
                        <li>
                            <span class="font-bold">{{__("over all")}}:</span>
                            <span>{{$eventTypeForm->eventType?->events()->count()}}</span>
                        </li>
                        <li>
                            <span class="font-bold">{{__("enabled")}}:</span>
                            <span>{{$eventTypeForm->eventType?->events()->where("enabled", true)->count()}}</span>
                        </li>
                        <li class="ml-4">
                            <span class="font-bold">{{__("future enabled")}}:</span>
                            <span>{{$eventTypeForm->eventType?->events()->where("enabled", true)->where("end", ">", now())->count()}}</span>
                        </li>
                    </ul>
                </div>
            </section>
        </div>
    </div>

</div>
