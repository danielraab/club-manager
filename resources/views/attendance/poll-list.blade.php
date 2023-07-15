@php
    $hasAttendancePollEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION) ?? false;
@endphp

<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <span>{{ __('Attendance Poll overview') }}</span>
            @if($hasAttendancePollEditPermission)
                <x-button-link href="{{route('attendancePoll.create')}}" class="btn-success"
                               title="Create new attendance poll">
                    {{__("New poll")}}
                </x-button-link>
            @endif
        </div>
    </x-slot>

    <div>
        <div class="flex bg-white overflow-hidden shadow-sm sm:rounded-lg p-5 justify-center gap-4  mb-5">
            <x-always-responsive-table class="table-auto mx-auto text-center">
                <thead class="font-bold">
                <tr>
                    <td class="px-4 py-2">{{__("Title")}}</td>
                    <td class="px-4 py-2">{{__("Closing at")}}</td>
                    <td class="px-4 py-2">{{__("Event count")}}</td>
                </tr>
                </thead>
                <tbody>
                @foreach(\App\Models\AttendancePoll::query()->orderByDesc("closing_at")->get() as $attendancePoll)
                    @php
                        /** @var \App\Models\AttendancePoll $attendancePoll */
                        $rowBg = "bg-lime-200";
                        if($attendancePoll->closing_at && $attendancePoll->closing_at < now()) {
                            $rowBg = "bg-gray-400";
                        }
                    @endphp
                    <tr class="[&:nth-child(2n)]:bg-opacity-50 {{$rowBg}}">
                        <td class="px-4">{{$attendancePoll->title}}</td>
                        <td class="px-4">{{$attendancePoll->closing_at?->setTimezone(config("app.displayed_timezone"))->isoFormat("ddd D. MMM YYYY HH:mm")}}</td>
                        <td class="px-4">{{$attendancePoll->events()->count()}}</td>
                        <td>
                            <div class="flex gap-2 justify-end py-2 px-4 items-center">
                            @if($attendancePoll->isPublicPollAvailable())
                                <a href="{{route('attendancePoll.public', $attendancePoll->id)}}"
                                   target="_blank">
                                    <i class="fa-solid fa-link text-amber-800"></i>
                                </a>
                            @endif
                                <a href="{{route('attendancePoll.statistic', $attendancePoll->id)}}" title="Show summary of attendance poll">
                                    <i class="fa-solid fa-circle-info text-sky-700"></i>
                                </a>
                            @if($hasAttendancePollEditPermission)
                                <x-button-link href="{{route('attendancePoll.edit', $attendancePoll->id)}}" title="Edit this attendance poll"
                                               class="bg-gray-800 text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </x-button-link>
                            @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </x-always-responsive-table>
        </div>
    </div>
</x-backend-layout>
