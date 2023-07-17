@php
    /** @var \App\Models\AttendancePoll $attendancePoll */

    $hasAttendanceShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_SHOW_PERMISSION) ?? false;
    $hasAttendanceEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_EDIT_PERMISSION) ?? false;
@endphp

<x-slot name="headline">
    <div class="flex flex-wrap justify-between items-center gap-3">
        <span>{{ __('Attend poll') }}</span>
    </div>
</x-slot>

<div x-data="{selectedMember: @entangle('selectedMember'), resetSelected() {
    $wire.set('selectedMember', null);
    $wire.set('memberSelection', '');
}}">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex flex-col">
            <span class="text-gray-700 text-xl">{{$poll->title}}</span>
            <span class="text-gray-500">{{$poll->description}}</span>
        </div>

        <div class="flex justify-center my-3">
            <div>
                <x-input-label for="memberSelection" :value="__('Member')"/>
                <div class="flex gap-3">
                    <select id="memberSelection" name="memberSelection"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1"
                            wire:model="memberSelection"
                            required autofocus autocomplete="memberSelection"
                            @disabled($selectedMember !== null)>
                        <option></option>
                        @foreach(\App\Models\Member::allActive()->get() as /** @var \App\Models\Member $member */ $member)
                            <option value="{{$member->id}}">{{$member->getFullName()}}</option>
                        @endforeach
                    </select>
                    <x-default-button type="button" class="btn btn-primary px-3 rounded"
                                      x-on:click="resetSelected"
                                      :disabled="$selectedMember === null">x
                    </x-default-button>
                </div>
                @if($selectedMember === null)
                    <span class="text-xs text-gray-600">Start type in your name until you find it in the list.</span>
                @endif
                @error('member')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
        </div>
    </div>


    <div class="flex bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 justify-center">
        @if($selectedMember !== null)
            <div class="table min-w-full divide-y">
                @foreach($poll->events()->get() as $event)
                    <div class="flex flex-wrap flex-col sm:table-row py-3">
                        <div
                            class="text-gray-500 text-center sm:table-cell">{{$event->start->setTimezone(config("app.displayed_timezone"))->isoFormat("ddd D. MMM YYYY HH:mm")}}</div>
                        <div class="text-gray-700 text-center sm:table-cell">{{$event->title}}</div>
                        <div class="flex justify-center sm:table-cell">

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <span>Please select your name first.</span>
        @endif
    </div>
</div>
