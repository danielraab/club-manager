@php
    /** @var \App\Livewire\Forms\PollForm $pollForm */
    $hasPollShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION) ?? false;
    $hasAttendanceShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_SHOW_PERMISSION) ?? false;
    $hasAttendanceEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_EDIT_PERMISSION) ?? false;
@endphp
<x-slot name="headline">
    <div class="flex gap-3 items-center">
        <a href="{{route("attendancePoll.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Update attendance poll") }}
    </div>
</x-slot>

<div x-data="{additionalEventList:[],
addEvents() {
    $wire.addEventsToSelection(this.additionalEventList);
    this.additionalEventList = [];
}}">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex justify-end gap-2 items-center">
         <span x-cloak class="text-gray-500 text-xs mt-1"
               x-show="additionalEventList.length > 0">Add selected events or unselect them.</span>
        <x-button-dropdown>
            <x-slot name="mainButton">
                <button type="button" class="btn-success p-2 text-xs inline-flex items-center gap-2"
                        x-bind:disabled="additionalEventList.length > 0"
                        wire:click="savePoll" title="Save this poll">
                    <i class="fa-solid fa-floppy-disk"></i> {{ __('Save') }}</button>
            </x-slot>
            @if($hasPollShowPermission)
                <a href="{{route('attendancePoll.statistic', $pollForm->poll->id)}}" class="btn-secondary text-xs p-2 inline-flex"
                   title="Show summary of attendance poll">
                    {{__("Show summary")}}
                </a>
            @endif
            <button type="button" class="text-xs p-2 btn-danger inline-flex gap-2"
                    wire:confirm="{{__('Are you sure you want to delete this attendance poll?')}}"
                    wire:click="deletePoll" title="Delete this attendance poll."
            ><i class="fa-solid fa-trash"></i> {{ __('Delete event') }}</button>
        </x-button-dropdown>
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
