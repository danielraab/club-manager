@php
    /** @var \App\Models\AttendancePoll $poll */
    $hasShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION) ?? false;
    $hasAttendancePollEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION) ?? false;

@endphp
@if($hasShowPermission || $hasAttendancePollEditPermission)
    <div class="flex-1 flex flex-col mb-3 bg-white shadow-sm sm:rounded-lg p-4 text-center">
        <div class="flex justify-center items-center gap-2 text-xl">
            <i class="fa-solid fa-calendar"></i>
            <span>{{__('event management')}}</span>
        </div>
        <hr class="my-3">
        @php($pollList = \App\Models\AttendancePoll::query()->where('closing_at','>',now()))
        @if($pollList->count())
            <header class="font-bold mb-3">{{__('Active polls')}}</header>
            <ul class="grid text-sm gap-2 text-white">
                @foreach($pollList->get() as $poll)
                    <li class="flex flex-wrap justify-center bg-green-700 p-1 rounded gap-4">
                        <span>{{$poll->title}}</span>
                        <div class="flex items-center gap-4">
                            @if($poll->isPublicPollAvailable())
                                <a href="{{route('attendancePoll.public', $poll->id)}}"
                                   title="{{__("Public link for poll")}}"
                                   target="_blank">
                                    <i class="fa-solid fa-link"></i>
                                </a>
                            @endif
                            <a href="{{route('attendancePoll.statistic', $poll->id)}}"
                               title="{{__("Show summary of attendance poll")}}">
                                <i class="fa-solid fa-circle-info"></i>
                            </a>
                            @if($hasAttendancePollEditPermission)
                                <a href="{{route('attendancePoll.edit', $poll->id)}}"
                                   title="Edit this attendance poll">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <span class="text-gray-500">{{__('no active polls')}}</span>
        @endif
        @if($futureDisabledCnt = \App\Models\Event::query()->where('start', '>', now())->where('enabled', false)->count())
            <hr class="my-3">
            <div class="text-yellow-500">
                <i class="fa-solid fa-ban"></i>
                <span>{{__(':cnt future but disabled event(s)', ['cnt' => $futureDisabledCnt])}}</span>
            </div>
        @endif
    </div>
@endif
