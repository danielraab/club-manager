@props(["eventType"])
@php
    /** @var \App\Models\EventType $eventType */
@endphp
<div {{$attributes}}>
    <div class="border border-sky-500 px-2 py-1 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-caret-right mx-2"></i>
            <div>
                <div class="text-sm sm:text-base">
                    {{$eventType->title}}
                </div>
                <div class="text-xs text-gray-500">{{$eventType->description}}</div>
            </div>
        </div>

        <div class="mx-2 flex gap-2 items-center">
            <span class="text-gray-500" title="{{__("enabled events")}}">{{$eventType->events()->where("enabled", true)->count()}}</span>
            <a href="{{route('event.type.edit', $eventType->id)}}" title="Edit this event type"
                           class="btn btn-primary">
                <i class="fa-regular fa-pen-to-square"></i>
            </a>
        </div>
    </div>
    @php($children = $eventType->children()->get())

    @if($children->isNotEmpty())
        <div class="ml-10">
            @foreach($children as $child)
                <x-events.event-type-list-item :eventType="$child"/>
            @endforeach
        </div>
    @endif
</div>
