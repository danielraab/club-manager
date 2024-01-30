@props(["events", "hasEventEditPermission" => false])
<ul class="my-2 ml-5 list-[circle] space-y-1">
    @foreach($events as $event)
        @php
            /** @var \App\Models\Event $event */
        @endphp
        <li>
            @if($hasEventEditPermission)
                <x-button-link href="{{route('event.edit', $event->id)}}"
                               title="Edit this event"
                               class="bg-gray-800 text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <i class="fa-regular fa-pen-to-square"></i>
                </x-button-link>
            @endif
            <span>{{$event->start->formatDateOnly(true)}} - {{$event->title}}</span>
        </li>
    @endforeach
</ul>
