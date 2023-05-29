@props(["eventType"])
@php
    /** @var \App\Models\EventType $eventType */
@endphp
<div>
    <div class="border border-sky-500 px-2 py-1 my-2 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-caret-right mx-2"></i>
            <div>
                <div class="text-sm sm:text-base">
                    {{$eventType->title}}
                </div>
                <div class="text-xs text-gray-500">{{$eventType->description}}</div>
            </div>
        </div>

        <x-button-link href="{{route('event.type.edit', $eventType->id)}}" title="Edit this event type"
                       class="mx-2 bg-gray-800 text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <i class="fa-regular fa-pen-to-square"></i>
        </x-button-link>
    </div>
    @php($children = $eventType->children()->get())
    @if($children)
        <div class="ml-10">
            @foreach($children as $child)
                <x-events.event-type-list-item :eventType="$child"/>
            @endforeach
        </div>
    @endif
</div>
