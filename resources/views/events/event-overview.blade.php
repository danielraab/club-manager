@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Event::EVENT_EDIT_PERMISSION) ?? false;
@endphp

<div>
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


    <div class="flex">
        <x-input-search wire:model.lazy="search" wire:click="$refresh"/>
    </div>

    <div class="flex justify-center my-3">
        {!! $eventList->links('vendor.livewire.paginator') !!}
    </div>

    <div class="flex flex-col gap-3 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
        <x-always-responsive-table class="table-auto mx-auto text-center">
            <thead class="font-bold">
            <tr>
                <td>start</td>
                <td class="min-w-[150px]">title</td>
                <td class="min-w-[150px]">type</td>
                @if($hasEditPermission)
                    <td>action</td>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($eventList as $event)
                @php
                    $rowBg = "bg-sky-200";
                    if(!$event->enabled) $rowBg = "bg-red-200";
                    elseif($event->end < now()) $rowBg = "bg-gray-300";
                @endphp
                <tr class="[&:nth-child(2n)]:bg-opacity-50 {{$rowBg}}">
                    <td class="border px-1 min-w-[150px]">{{$event->start->isoFormat("ddd D. MMM YYYY HH:mm")}}</td>
                    <td class="border px-2">
                        @if($hasEditPermission && $event->logged_in_only)
                            <i class="fa-solid fa-arrow-right-to-bracket text-sm text-gray-600 mr-2"
                               title="{{__("Visible only for logged in users")}}"></i>
                        @endif
                        {{$event->title}}
                    </td>
                    <td class="border px-2">{{$event->eventType?->title}}</td>
                    @if($hasEditPermission)
                        <td class="border px-2">
                            <div class="flex gap-2">
                                @if($event->enabled)
                                    <button type="button" title="Disable this event" class="text-green-600"
                                            wire:click="toggleEnabledState({{$event->id}})">
                                        <i class="fa-solid fa-toggle-on text-base"></i>
                                    </button>
                                @else
                                    <button type="button" title="Disable this event" class="text-red-500"
                                            wire:click="toggleEnabledState({{$event->id}})">
                                        <i class="fa-solid fa-toggle-off text-base"></i>
                                    </button>
                                @endif
                                <x-button-link href="{{route('event.edit', $event->id)}}" title="Edit this event"
                                               class="bg-gray-800 text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </x-button-link>
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </x-always-responsive-table>
    </div>
    <div class="flex justify-center mt-3">
        {!! $eventList->links('vendor.livewire.paginator') !!}
    </div>


</div>
