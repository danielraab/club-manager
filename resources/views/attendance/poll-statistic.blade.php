@php
    /** @var \App\Models\AttendancePoll $attendancePoll */
    $hasAttendanceShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_SHOW_PERMISSION) ?? false;
    $hasAttendanceEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_EDIT_PERMISSION) ?? false;
@endphp

<x-backend-layout>
    <x-slot name="headline">
        <div class="flex flex-wrap justify-between items-center gap-3">
            <span>{{ __('Attendance poll statistic') }}</span>
        </div>
    </x-slot>

    <div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
            <div class="flex flex-col">
                <span class="text-gray-700 text-xl">{{$attendancePoll->title}}</span>
                <span class="text-gray-500">{{$attendancePoll->description}}</span>
            </div>
        </div>

        <div class="flex bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 justify-center">
            <div class="table min-w-full divide-y">
                @foreach($attendancePoll->events()->get() as $event)
                    @php
                        /** @var \App\Models\Event $event */
                        $statistic = $event->getAttendanceStatistics();
                    @endphp
                    <div class="flex flex-wrap flex-col sm:table-row py-3">
                        <div
                            class="text-gray-500 text-center sm:table-cell">{{$event->start->setTimezone(config("app.displayed_timezone"))->isoFormat("ddd D. MMM YYYY HH:mm")}}</div>
                        <div class="text-gray-700 text-center sm:table-cell">{{$event->title}}</div>
                        <div class="flex justify-center sm:table-cell">
                            <div class="flex sm:grid grid-cols-4 place-items-center">
                                <span class="text-white bg-green-700 rounded-full px-2 m-1">{{$statistic["in"]}}</span>
                                <span
                                    class="text-white bg-yellow-700 rounded-full px-2 m-1">{{$statistic["unsure"]}}</span>
                                <span class="text-white bg-red-700 rounded-full px-2 m-1">{{$statistic["out"]}}</span>
                                <span class="text-white text-center bg-green-700 px-2 m-1"><i
                                        class="fa-solid fa-check"></i> {{$statistic["attended"]}}
                            </div>
                        </div>
                        <div class="px-2 sm:table-cell">
                            <div class="flex justify-center gap-2">
                                @if($hasAttendanceShowPermission)
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
                @endforeach
            </div>
        </div>
    </div>
</x-backend-layout>
