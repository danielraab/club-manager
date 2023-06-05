<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Update event") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex flex-wrap gap-2 items-center justify-between">
            <x-default-button
                x-data="{ clickCnt: 0, onClick() {
                if(this.clickCnt > 0) {
                    $wire.deleteEvent();
                } else {
                    this.clickCnt++;
                    $el.innerHTML = 'Are you sure?';
                }
            }}"
                x-on:click="onClick()" title="Delete this event"
                class="btn-danger">{{ __('Delete event') }}</x-default-button>
            <div class="flex flex-wrap gap-2 justify-end w-full sm:w-auto">
                <x-default-button class="bg-cyan-700 hover:bg-cyan-500 focus:bg-cyan-500 text-white"
                                  wire:click="saveEventCopy"
                                  title="Save copy of the event">{{ __('Save copy') }}</x-default-button>
                <x-default-button class="btn-primary" wire:click="saveEvent"
                                  title="Update event">{{ __('Save') }}</x-default-button>
            </div>
        </div>
    </div>


    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.events.event-content :event="$event"/>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.events.event-settings :event="$event"/>
        </div>
    </div>

</div>
