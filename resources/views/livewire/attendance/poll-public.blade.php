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

<div x-data="{selectedMember: @entangle('selectedMember')}">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex flex-col">
            <span class="text-gray-700 text-xl">{{$poll->title}}</span>
            <span class="text-gray-500">{{$poll->description}}</span>
        </div>

        <div class="flex justify-center my-3">
            <div>
                <x-input-label for="memberSelection" :value="__('Member')"/>
                <x-text-input id="memberSelection" name="memberSelection" type="text" class="mt-1 block"
                              wire:model="memberSelection" list="possibleMemberList"
                              required autofocus autocomplete="memberSelection"/>
                <datalist id="possibleMemberList">
{{--                    @foreach(\App\Models\Event::getLocationHistory() as $location)--}}
                        <option value="1">test</option>
{{--                    @endforeach--}}
                </datalist>
                <span class="text-xs text-gray-600" x-show="selectedMember === null">Start type in your name until you find it in the list.</span>
                @error('member')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
        </div>
    </div>


    <div class="flex bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 justify-center">
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
    </div>
</div>
