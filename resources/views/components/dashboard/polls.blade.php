@php
    /** @var \App\Models\AttendancePoll $poll */
    $hasShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION) ?? false;
@endphp
@if($hasShowPermission)
    <div class="flex flex-col mb-3">
        @php($pollList = \App\Models\AttendancePoll::query()->where('closing_at','>',now()))
        <div class="bg-white shadow-sm sm:rounded-lg p-4 text-center">
        @if($pollList->count())
            <header class="font-bold mb-3">{{__('Active polls')}}</header>
            <ul class="grid text-sm gap-2">
                @foreach($pollList->get() as $poll)
                    <li class="grow bg-green-600 p-2 rounded">{{$poll->title}}</li>
                @endforeach
            </ul>
            @else
                <span class="text-gray-500">{{__('no active polls')}}</span>
            @endif
        </div>
    </div>
@endif
