@php
    /** @var \App\Livewire\Forms\PollForm $pollForm */
    $hasAttendanceShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_SHOW_PERMISSION) ?? false;
    $hasAttendanceEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_EDIT_PERMISSION) ?? false;
@endphp
<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Update attendance poll") }}
    </div>
</x-slot>

<div x-data="{additionalEventList:[],
addEvents() {
    $wire.addEventsToSelection(this.additionalEventList);
    this.additionalEventList = [];
}}">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex justify-between gap-2 items-center">
        <button type="button"
                x-data="{ clickCnt: 0, onClick() {
                        if(this.clickCnt > 0) {
                            $wire.deletePoll();
                        } else {
                            this.clickCnt++;
                            $el.innerHTML = 'Are you sure?';
                        }
                    }}"
                x-on:click="onClick()" title="Delete this poll"
                class="btn-danger">{{ __('Delete poll') }}</button>
        <div class="flex gap-2 items-center">
            <span x-cloak class="text-gray-500 text-xs mt-1"
                  x-show="additionalEventList.length > 0">Add selected events or unselect them.</span>
            <div class="ml-auto">
                <button type="button" class="btn-primary inline-flex" wire:click="savePoll"
                        x-bind:disabled="additionalEventList.length > 0"
                        title="Update attendance poll">{{ __('Save') }}</button>
            </div>
        </div>
    </div>


    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.attendance.poll-basics/>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.attendance.poll-event-selection :pollForm="$pollForm"/>
        </div>
    </div>

</div>
