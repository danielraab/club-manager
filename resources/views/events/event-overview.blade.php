@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Event::EVENT_EDIT_PERMISSION);
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <span>{{ __('Event Overview') }}</span>
            @if($hasEditPermission)
                <x-button-link href="{{route('event.create')}}" class="btn-success"
                               title="Create new event">
                    {{__("Add new event")}}
                </x-button-link>
            @endif
        </div>
    </x-slot>

    <div class="flex justify-center mb-3">
        {!! $eventList->links('vendor.pagination.paginator') !!}
    </div>

    <div class="flex flex-col gap-3 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
        <x-always-responsive-table class="table-auto mx-auto text-center">
            <thead class="font-bold">
            <tr>
                <td>start</td>
                <td>title</td>
                <td>type</td>
                <td>action</td>
            </tr>
            </thead>
            <tbody>
            @foreach($eventList as $event)
                <tr class="[&:nth-child(2n)]:bg-indigo-200">
                    <td class="border px-4">{{$event->start}}</td>
                    <td class="border px-4">{{$event->title}}</td>
                    <td class="border px-4">{{$event->eventType?->title}}</td>
                    <td class="border px-4">
                        @if($hasEditPermission)
                            <x-button-link href="{{route('event.edit', $event->id)}}" title="Edit this event"
                                           class="mx-2 bg-gray-800 text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </x-button-link>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </x-always-responsive-table>
    </div>
    <div class="flex justify-center mt-3">
        {!! $eventList->links('vendor.pagination.paginator') !!}
    </div>
</x-backend-layout>
