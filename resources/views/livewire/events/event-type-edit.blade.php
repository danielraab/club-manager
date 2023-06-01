<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Update event type") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex items-center justify-between">
            <x-default-button
                x-data="{ clickCnt: 0, onClick() {
                if(this.clickCnt > 0) {
                    $wire.deleteEventType();
                } else {
                    this.clickCnt++;
                    $el.innerHTML = 'Are you sure?';
                }
            }}"
                x-on:click="onClick()" title="Delete this event type"
                class="btn-danger">{{ __('Delete event type') }}</x-default-button>
            <x-default-button class="btn-primary" wire:click="saveEventType"
                              title="Create new event type">{{ __('Save') }}</x-default-button>
        </div>
    </div>


    <div class="flex justify-center">

        <x-livewire.events.event-type-content :eventType="$eventType"/>

    </div>

</div>
