@props(["events", "hasEventEditPermission" => false])
<ul class="my-2 ml-5 list-[circle] space-y-1">
    @foreach($events as $event)
        @php
            /** @var \App\Models\Event $event */
        @endphp
        <li>
            @if($hasEventEditPermission)
                <a href="{{route('event.edit', $event->id)}}"
                               title="Edit this event"
                               class="btn btn-primary">
                    <i class="fa-regular fa-pen-to-square"></i>
                </a>
            @endif
            <span>{{$event->start->formatDateOnly(true)}} - {{$event->title}}</span>
        </li>
    @endforeach
</ul>
