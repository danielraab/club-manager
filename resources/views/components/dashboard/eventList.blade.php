@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Event::EVENT_EDIT_PERMISSION) ?? false;
    $hasAttendanceShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_SHOW_PERMISSION) ?? false;
    $hasAttendanceEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_EDIT_PERMISSION) ?? false;
@endphp

<div class="flex flex-col gap-2">

    @forelse($eventList as $event)
        @php
            /** @var \App\Models\Event $event */
            $end = null;
            if(!$event->end->isSameDay($event->start)) {
                $end = $event->getFormattedEnd();
            }
        @endphp

        <div class="bg-green-100 text-green-700 px-4 py-3">
            <div class="flex gap-2 justify-between items-center">
                <p class="text-green-500">
                    <i class="fa-regular fa-calendar"></i> {{$event->getFormattedStart()}}
                    @if($end) --- {{$end}} @endif
                </p>
                <div class="flex gap-2">
                    @if($event->link)
                        <a href="{{$event->link}}" target="_blank" title="{{__("Link")}}"><i class="fa-solid fa-link"></i></a>
                    @endif
                    @if($hasAttendanceEditPermission)
                        <a href="{{route('event.attendance.edit', $event->id)}}" target="_self"
                           title="{{__("Edit attendance of this event")}}">
                            <i class="fa-solid fa-check-to-slot"></i>
                        </a>
                    @endif
                    @if($hasEditPermission)
                        <a href="{{route('event.edit', $event->id)}}" title="Edit this event">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                    @endif
                </div>
            </div>
            <p class="font-bold">{{$event->title}}</p>
            <p class="text-sm">{{$event->description}}</p>
            <div class="text-sm text-green-500 mt-2">
                @if ($event->location)
                <p class="inline-block">
                    <i class="fa-solid fa-location-dot"></i> {{$event->location}}
                </p>
                @endif
                @if($event->dress_code)
                    <p class="inline-block">
                        <i class="fa-solid fa-shirt"></i> {{$event->dress_code}}
                    </p>
                @endif
            </div>
        </div>

    @empty
        <div class="text-center text-gray-500">
            <p>{{__("No events to display.")}}</p>
            <p>{{__("Check again later.")}}</p>
        </div>
    @endforelse
</div>
