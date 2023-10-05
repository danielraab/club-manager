@props(["eventType", "currentEditingEventTypeForm" => null, "level" => 0])
@php
/** @var \App\Models\EventType $eventType */
@endphp

@if($eventType->id !== $currentEditingEventTypeForm?->eventType?->id)
    <option
        value="{{ $eventType->id }}">{{str_repeat("|--- ", $level)}}{{ $eventType->title }}</option>
    @foreach($eventType->children()->get() as $child)
        <x-events.event-type-select-option :eventType="$child" :level="$level+1" :currentEditingEventTypeForm="$currentEditingEventTypeForm" />
    @endforeach
@endif
