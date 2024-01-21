@props(["eventType", "hasEventEditPermission" => false])
@php
    /** @var \App\Models\EventType $eventType */
    $events = $eventType->events()
            ->where("start", ">=", "$this->selectedYear-01-01 00:00:00")
            ->where("start", "<=", "$this->selectedYear-12-31 23:59:59")
            ->orderBy("start")
            ->get();
@endphp
<li>
    <div class="flex justify-between bg-gray-300 px-3 py-1 rounded">
        <span>{{$eventType->title}}</span>
        <span>{{$events->count()}}</span>
    </div>
    @if($events->count() > 0)
        <x-events.event-type-statistic-event-list :events="$events"
                                                  :hasEventEditPermission="$hasEventEditPermission"/>
    @endif

    @php($children = $eventType->children()->get())
    @if($children->isNotEmpty())
        <ul class="my-2 ml-5 list-disc">
            @foreach($children as $child)
                <x-events.event-type-statistic :eventType="$child"
                                               :hasEventEditPermission="$hasEventEditPermission"/>
            @endforeach
        </ul>
    @endif
</li>
