<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Create new attendance poll") }}
    </div>
</x-slot>

<div x-data="{additionalEventList:[],
addEvents() {
    $wire.addEventsToSelection(this.additionalEventList);
    this.additionalEventList = [];
}}">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3 p-5 flex justify-end gap-2 items-center">
        <span x-cloak class="text-gray-500 text-xs mt-1"
              x-show="additionalEventList.length > 0">Add selected events or unselect them.</span>
        <button type="button" class="btn btn-create inline-flex gap-2" wire:click="savePoll"
                x-bind:disabled="additionalEventList.length > 0"
                title="Create new attendance poll"><i class="fa-solid fa-plus"></i> {{ __('Create') }}</button>
    </div>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            @include('livewire.attendance.partials.poll-basics')
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            @include('livewire.attendance.partials.poll-event-selection')
        </div>
    </div>
</div>
