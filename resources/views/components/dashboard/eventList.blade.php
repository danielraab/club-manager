<div class="flex flex-col gap-2">

    @forelse($eventList as $event)
        @php
            if($event->whole_day) {
                $startFormat = "ddd D. MMM YYYY";
            }
            else {
                $startFormat = "ddd D. MMM YYYY - HH:mm U\hr";
            }
            $end = null;
            if(!$event->end->isSameDay($event->start)) {
                $end = $event->end->isoFormat($startFormat);
            }
        @endphp

        <div class="bg-green-100 text-green-700 px-4 py-3">
            <div class="flex justify-between">
                <p class="text-green-500">
                    <i class="fa-regular fa-calendar"></i> {{$event->start->isoFormat($startFormat)}}
                    @if($end) --- {{$end}} @endif
                </p>
                @if($event->link)
                    <a href="{{$event->link}}" target="_blank"><i class="fa-solid fa-link"></i></a>
                @endif
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
                    <p class="inline-block ml-2">
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
