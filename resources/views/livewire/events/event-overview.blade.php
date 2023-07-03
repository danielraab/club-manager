@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Event::EVENT_EDIT_PERMISSION) ?? false;
@endphp

<div>
    <x-slot name="headline">
        <div class="flex items-center">
            <span>{{ __('Event Overview') }}</span>
        </div>
    </x-slot>

    @if($hasEditPermission)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex flex-wrap justify-center sm:justify-end gap-2 items-center">
            <x-button-link href="{{route('event.type.index')}}" class="btn-secondary"
                           title="Show event type list">
                {{__("Event Type List")}}
            </x-button-link>
            <x-button-link href="{{route('event.create')}}" class="btn-success"
                           title="Create new event">
                {{__("Create new event")}}
            </x-button-link>
        </div>
    @endif

    <x-livewire.loading />

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
                <td>{{__("Start")}}</td>
                <td class="min-w-[150px]">{{__("Title")}}</td>
                <td class="min-w-[150px]">{{__("Type")}}</td>
                @if($hasEditPermission)
                    <td>{{__("Action")}}</td>
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
                    <td class="border px-1 min-w-[150px]">{{$event->start->setTimezone(config("app.displayed_timezone"))->isoFormat("ddd D. MMM YYYY HH:mm")}}</td>
                    <td class="border px-2">
                        <span class="text-sm text-gray-600 mr-1">
                        @if($event->link)
                                <a href="{{$event->link}}" target="_blank"><i class="fa-solid fa-link"></i></a>
                            @endif
                            @if($hasEditPermission && $event->logged_in_only)
                                <i class="fa-solid fa-arrow-right-to-bracket"
                                   title="{{__("Visible only for logged in users")}}"></i>
                            @endif
                        </span>
                        {{$event->title}}
                    </td>
                    <td class="border px-2">{{$event->eventType?->title}}</td>
                    @if($hasEditPermission)
                        <td class="border px-2 min-w-[70px]">
                            <div class="flex gap-2 justify-center">
                                @if($event->enabled)
                                    <button type="button" title="{{__("Disable this event")}}" class="text-green-600"
                                            wire:click="toggleEnabledState({{$event->id}})">
                                        <i class="fa-solid fa-toggle-on text-base"></i>
                                    </button>
                                @else
                                    <button type="button" title="{{__("Enable this event")}}" class="text-red-500"
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

    @if($hasEditPermission)

        <div x-data="{clickCnt: 0, onClick(btn) {
                if(this.clickCnt > 0) {
                    btn.disabled = true;
                    $wire.disableLastYearEvents();
                } else {
                    this.clickCnt++;
                    btn.innerHTML = 'Are you sure?';
                }
            }}"
             class="flex flex-col sm:flex-row gap-3 my-3 bg-white overflow-hidden items-center shadow-sm sm:rounded-lg p-6">
            <x-default-button
                x-on:click="onClick($el)" title="Disable all events older than this year."
                class="btn-danger">{{ __('Disable last years events') }}</x-default-button>
            @if(session()->has("eventDisableMessage"))
                <span class="text-gray-700">{{session()->pull("eventDisableMessage")}}</span>
            @endif
        </div>
    @endif
</div>
