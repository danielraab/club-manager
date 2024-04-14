@php
    $attendancePoll = $this->attendancePoll;
    /** @var \App\Models\AttendancePoll $attendancePoll */
    $memberStatistic = $this->memberStatistic;
    /** @var array $memberStatistic */
    $hasAttendanceShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_SHOW_PERMISSION) ?? false;
    $hasAttendanceEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_EDIT_PERMISSION) ?? false;
    $hasPollEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION) ?? false;
@endphp

<x-slot name="headline">
    <div class="flex flex-wrap justify-between items-center gap-3">
        <span>{{ __('Attendance poll statistic') }}</span>
    </div>
</x-slot>
<x-slot name="headerBtn">
    <div class="space-x-2">
        @if($attendancePoll->isPublicPollAvailable())
            <a href="{{route('attendancePoll.public', $attendancePoll->id)}}" class="btn btn-secondary inline-flex gap-2 items-center"
               title="Show public attendance poll">
                <i class="fa-solid fa-link"></i>
                <span class="max-sm:hidden">{{__("Public poll")}}</span>
            </a>
        @endif
        @if($hasPollEditPermission)
            <a href="{{route('attendancePoll.edit', $attendancePoll->id)}}" class="btn btn-primary inline-flex gap-2 items-center"
               title="Edit this attendance poll">
                <i class="fa-solid fa-pen-to-square"></i>
                <span class="max-sm:hidden">{{__("Edit Poll")}}</span>
            </a>
        @endif
    </div>
</x-slot>

<div>
    <x-livewire.loading/>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex flex-col">
            <span class="text-gray-700 text-xl">{{$attendancePoll->title}}</span>
            <span class="text-gray-500">{{$attendancePoll->description}}</span>
        </div>
    </div>

    <div class="flex bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 justify-center mb-5">
        <div class="table min-w-full">
            @foreach($attendancePoll->events()->orderBy('start')->get() as $event)
                @php
                    /** @var \App\Models\Event $event */
                    $statistic = (new \App\Calculation\AttendanceStatistic($event))->calculateStatistics();
                @endphp
                <div class="flex flex-wrap flex-col lg:flex-row items-center justify-between px-2 py-3 border-t
                @if($showMembers[$event->id] ?? false) bg-gray-300 @endif">
                    <div
                        class="text-gray-500 text-center">{{$event->getFormattedStart()}}</div>
                    <div class="text-gray-700 text-center">{{$event->title}}</div>
                    <div class="flex justify-center">
                        <div class="flex sm:grid grid-cols-4 place-items-center">
                            <span class="text-white bg-green-700 rounded-full px-2 m-1">{{$statistic->cntIn}}</span>
                            <span
                                class="text-white bg-yellow-700 rounded-full px-2 m-1">{{$statistic->cntUnsure}}</span>
                            <span class="text-white bg-red-700 rounded-full px-2 m-1">{{$statistic->cntOut}}</span>
                            <span class="text-white text-center bg-green-700 px-2 m-1"><i
                                    class="fa-solid fa-check"></i> {{$statistic->cntAttended}}
                        </div>
                    </div>
                    <div class="px-2">
                        <div class="flex justify-center gap-2">
                            @if($hasAttendanceShowPermission)
                                <button title="{{__("Show attendance of this event")}}" type="button"
                                        class="btn btn-primary inline-flex items-center px-2 py-1"
                                        wire:click="toggleShowMember({{$event->id}})">
                                    <i class="fa-solid fa-square-poll-horizontal"></i>
                                    <i class="ml-1 fas @if($showMembers[$event->id] ?? false) fa-caret-up @else fa-caret-down @endif"></i>
                                </button>
                                <a href="{{route('event.attendance.show', $event->id)}}"
                                   title="{{__("Show attendance of this event")}}"
                                   class="inline-flex items-center text-indigo-700 p-0">
                                    <i class="fa-solid fa-square-poll-horizontal"></i>
                                </a>
                            @endif
                            @if($hasAttendanceEditPermission)
                                <a href="{{route('event.attendance.edit', $event->id)}}"
                                   title="{{__("Edit attendance of this event")}}"
                                   class="inline-flex items-center text-cyan-900 p-0">
                                    <i class="fa-solid fa-check-to-slot"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @if($showMembers[$event->id] ?? false)
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 justify-center py-3">
                            @forelse($members = \App\Models\Member::query()->get() as $member)
                                @php
                                    /** @var \App\Models\Member $member */
                                    $attendance = $member->attendances()->where("event_id", $event->id)->first();
                                    if($attendance === null) continue;
                                @endphp
                                <x-attendance.list-item-display :attendance="$attendance" :member="$member"/>
                            @empty
                                <span>{{__("Currently no attendance information.")}}</span>
                            @endforelse
                        </div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
        <div class="text-gray-700 text-xl mb-5">{{__("Member attendances")}}</div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-y-3 justify-center">
            @foreach($memberStatistic as $id => $attendanceCnt)
                <div>
                    <span class="font-bold">{{$attendanceCnt}} x</span>
                    <span>{{\App\Models\Member::query()->find($id)?->getFullname()}}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
</div>
