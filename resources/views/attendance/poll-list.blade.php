@php
    $hasAttendancePollEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION) ?? false;
@endphp

<x-backend-layout>
    <x-slot name="headline">
            {{ __('Attendance Polls') }}
    </x-slot>
    @if($hasAttendancePollEditPermission)
        <x-slot name="headerBtn">
        <a href="{{route('attendancePoll.create')}}" class="btn btn-success max-sm:text-lg gap-2"
           title="Create new attendance poll">
            <i class="fa-solid fa-plus"></i>
            <span class="max-sm:hidden">{{__("New poll")}}</span>
        </a>
        </x-slot>
    @endif


    <div>
        <div class="flex bg-white overflow-hidden shadow-sm sm:rounded-lg p-5 justify-center gap-4  mb-5">
            @php
                $attendancePollList = \App\Models\AttendancePoll::query()->orderByDesc("closing_at")->get()
            @endphp
            @if($attendancePollList->count() > 0)
                <x-always-responsive-table class="table-auto mx-auto text-center w-full">
                    <thead class="font-bold">
                    <tr class="max-md:hidden">
                        <td class="px-4 py-2">{{__("Title")}}</td>
                        <td class="px-4 py-2">{{__("Closing at")}}</td>
                        <td class="px-4 py-2">{{__("Event count")}}</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($attendancePollList as $attendancePoll)
                        @php
                            /** @var \App\Models\AttendancePoll $attendancePoll */
                            $rowBg = "bg-lime-200";
                            if($attendancePoll->closing_at && $attendancePoll->closing_at < now()) {
                                $rowBg = "bg-gray-400";
                            }
                        @endphp
                        <tr class="max-md:flex flex-col text-center [&:nth-child(2n)]:bg-opacity-50 {{$rowBg}}">
                            <td class="px-4 max-md:block">{{$attendancePoll->title}}</td>
                            <td class="px-4 max-md:block">{{$attendancePoll->closing_at?->setTimezone(config("app.displayed_timezone"))->isoFormat("ddd D. MMM YYYY HH:mm")}}</td>
                            <td class="px-4 max-md:hidden">{{$attendancePoll->events()->count()}}</td>
                            <td class="flex justify-center md:justify-end items-center">
                                <span class="px-4 md:hidden">{{$attendancePoll->events()->count()}} {{__('event(s)')}}</span>
                                <div class="flex gap-2 justify-end py-2 px-4 items-center">
                                    @if($attendancePoll->isPublicPollAvailable())
                                        <a href="{{route('attendancePoll.public', $attendancePoll->id)}}"
                                           title="{{__("Public link for poll")}}"
                                           target="_blank">
                                            <i class="fa-solid fa-link text-amber-800"></i>
                                        </a>
                                    @endif
                                    <a href="{{route('attendancePoll.statistic', $attendancePoll->id)}}"
                                       title="{{__("Show summary of attendance poll")}}">
                                        <i class="fa-solid fa-circle-info text-sky-700"></i>
                                    </a>
                                    @if($hasAttendancePollEditPermission)
                                        <a href="{{route('attendancePoll.edit', $attendancePoll->id)}}"
                                                       title="Edit this attendance poll"
                                                       class="btn btn-primary">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </x-always-responsive-table>
            @else
                <span>{{__("No attendance polls to display.")}}</span>
            @endif
        </div>
    </div>
</x-backend-layout>
