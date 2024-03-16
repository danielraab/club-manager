<x-slot name="headline">
    <div class="flex gap-3 items-center">
        <a href="{{route("event.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Update event") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex flex-wrap gap-2 items-center justify-between">
            <div class="flex flex-wrap gap-2 justify-start w-full sm:w-auto">
                <button type="button"
                        x-data="{ clickCnt: 0, onClick() {
                        if(this.clickCnt > 0) {
                            $wire.deleteEvent();
                        } else {
                            this.clickCnt++;
                            $el.innerHTML = 'Are you sure?';
                        }
                    }}"
                        x-on:click="onClick()" title="Delete this event"
                        class="btn btn-danger">{{ __('Delete event') }}</button>

                @if($eventForm->start > now() && $eventForm->enabled && !$eventForm->logged_in_only)
                    <button type="button"
                            x-data="{ clickCnt: 0, disabled: false, onClick() {
                            if(this.clickCnt == 1) {
                                $wire.forceWebPush();
                                this.disabled = true;
                            } else {
                                this.clickCnt++;
                                $el.innerHTML = 'Are you sure?';
                            }
                        }}"
                            x-on:click="onClick()" title="Force a web push to all subscribes (with the updated data)."
                            x-bind:disabled="disabled"
                            class="btn btn-secondary">{{ __('Force web push') }}</button>
                @endif
            </div>
            <div class="flex flex-wrap gap-2 justify-end w-full sm:w-auto">
                <button type="button" class="bg-cyan-700 hover:bg-cyan-500 focus:bg-cyan-500 text-white"
                        wire:click="saveEventCopy"
                        title="Save copy of the event">{{ __('Save copy') }}</button>
                <button type="button" class="btn btn-primary" wire:click="saveEvent"
                        title="Update event">{{ __('Save') }}</button>
            </div>
        </div>
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
