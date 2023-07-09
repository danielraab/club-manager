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
                    <td class="px-4 py-2">Title</td>
                    <td class="px-4 py-2">{{__("Closing at")}}</td>
                </tr>
                </thead>
                <tbody>
                @foreach(\App\Models\AttendancePoll::query()->orderByDesc("closing_at")->get() as $attendancePoll)
                    @php
                        /** @var \App\Models\AttendancePoll $attendancePoll */
                        $rowBg = "bg-lime-200";
                        if($attendancePoll->enabled) {
                            $rowBg = "bg-red-200";
                        } elseif($attendancePoll->closing_at && $attendancePoll->closing_at < now()) {
                            $rowBg = "bg-gray-400";
                        }
                    @endphp
                    <tr class="[&:nth-child(2n)]:bg-opacity-50 {{$rowBg}}">
                        <td>
                            @if($attendancePoll->allow_anonymous_vote)
                                <a href="" target="_blank"><i class="fa-solid fa-link"></i></a>
                            @endif
                        </td>
                        <td>{{$attendancePoll->title}}</td>
                        <td>{{$attendancePoll->closing_at?->setTimezone(config("app.displayed_timezone"))->isoFormat("ddd D. MMM YYYY HH:mm")}}</td>
                    </tr>
                @endforeach
                </tbody>
            </x-always-responsive-table>

        </div>
    </div>
</x-backend-layout>
