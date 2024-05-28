@php
    /** @var \App\Models\AttendancePoll $poll */
    $hasShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION) ?? false;
    $hasAttendancePollEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION) ?? false;

@endphp
@if($hasShowPermission)
    <div class="flex-1 flex flex-col mb-3">
        @php($pollList = \App\Models\AttendancePoll::query()->where('closing_at','>',now()))
        <div class="bg-white shadow-sm sm:rounded-lg p-4 text-center">
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
        </div>
    </div>
@endif
