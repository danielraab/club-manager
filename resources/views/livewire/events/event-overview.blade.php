@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Event::EVENT_EDIT_PERMISSION) ?? false;
    $hasAttendanceShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_SHOW_PERMISSION) ?? false;
    $hasAttendanceEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_EDIT_PERMISSION) ?? false;
    /** @var \App\Models\Filter\EventFilter $eventFilter */
    $eventFilter = $this->getEventFilter();
@endphp

<div x-init="$store.notificationMessages
            .addNotificationMessages(
            JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))">
    <x-slot name="headline">
        <div class="flex items-center">
            <span>{{ __('Event Overview') }}</span>
        </div>
    </x-slot>
    <div
        class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex flex-wrap gap-2 items-center justify-between">
        <div class="flex flex-row flex-wrap gap-2 justify-center max-sm:grow">
            @auth
                <x-button-link href="{{route('event.statistic')}}" class="btn-primary" title="Calendar">
                    <i class="fa-solid fa-chart-simple mr-1"></i>
                    {{__("Statistic")}}
                </x-button-link>
            @endauth
            <x-button-link href="{{route('event.calendar')}}" class="btn-success max-md:hidden" title="Calendar">
                <i class="fa-solid fa-calendar-days mr-1"></i>
                {{__("Calendar")}}
            </x-button-link>
        </div>
        @if($hasEditPermission)
            <div class="flex flex-row flex-wrap gap-2 justify-center">
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
    </div>

    <x-livewire.loading/>

    <div class="flex flex-wrap justify-center items-center gap-3">
        <x-input-search wire:model.live.debounce.1000ms="search" wire:click="$refresh"/>
        <x-livewire.filter.event-filter/>
    </div>

    <div class="flex justify-center my-3">
        {!! $eventList->links('vendor.livewire.paginator') !!}
    </div>

    <div class="flex flex-col gap-3 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
        @if($eventList->isEmpty())
            <span class="text-center">{{__("No events to display.")}}</span>
        @else
            <x-always-responsive-table class="table-auto mx-auto text-center">
                <thead class="font-bold">
                <tr class="max-md:hidden">
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
                        /** @var \App\Models\Event $event */
                        $rowBg = "bg-sky-200";
                        if(!$event->enabled) $rowBg = "bg-red-200";
                        elseif($event->end < now()) $rowBg = "bg-gray-300";
                    @endphp
                    <tr class="[&:nth-child(2n)]:bg-opacity-50 max-md:block max-md:py-2 {{$rowBg}}">
                        <td class="md:border px-1 min-w-[150px] max-md:block">
                            {{$event->getFormattedStart()}}
                        </td>
                        <td class="md:border px-2 max-md:block">
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
                            @if($event->location && strlen(trim($event->location)) > 0)
                                <p class="text-gray-500">{{$event->location}}</p>
                            @endif
                        </td>
                        <td class="md:border px-2 max-md:hidden">{{$event->eventType?->title}}</td>
                        @if($hasEditPermission || $hasAttendanceShowPermission || $hasAttendanceEditPermission)
                            <td class="md:border px-2 min-w-[70px] max-md:block">
                                <div class="flex gap-2 justify-center">
                                    @if($hasAttendanceShowPermission)
                                        <a href="{{route('event.attendance.show', $event->id)}}"
                                           title="{{__("Show attendance of this event")}}"
                                           class="inline-flex items-center text-indigo-700 p-0">
                                            <i class="fa-solid fa-square-poll-horizontal"></i>
                                        </a>
                                    @endif
                                    @if($hasAttendanceEditPermission)
                                        <a href="{{route('event.attendance.edit', $event->id)}}"
                                           title="{{__("Edit attendance of this event")}}"
                                           class="inline-flex items-center text-cyan-900 p-0">
                                            <i class="fa-solid fa-check-to-slot"></i>
                                        </a>
                                    @endif
                                    @if($hasEditPermission)
                                        @if($event->enabled)
                                            <button type="button" title="{{__("Disable this event")}}"
                                                    class="text-green-600"
                                                    wire:click="toggleEnabledState({{$event->id}})">
                                                <i class="fa-solid fa-toggle-on text-base"></i>
                                            </button>
                                        @else
                                            <button type="button" title="{{__("Enable this event")}}"
                                                    class="text-red-500"
                                                    wire:click="toggleEnabledState({{$event->id}})">
                                                <i class="fa-solid fa-toggle-off text-base"></i>
                                            </button>
                                        @endif
                                        <x-button-link href="{{route('event.edit', $event->id)}}"
                                                       title="Edit this event"
                                                       class="bg-gray-800 text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </x-button-link>
                                    @endif
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </x-always-responsive-table>
        @endif
    </div>
    <div class="flex justify-center mt-3">
        {!! $eventList->links('vendor.livewire.paginator') !!}
    </div>

    @auth
        <div
            class="flex flex-col sm:flex-row gap-3 my-3 bg-white items-center shadow-sm sm:rounded-lg p-5 justify-between">

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
                >
                    <x-default-button
                        x-on:click="onClick($el)" title="Disable all events older than this year."
                        class="btn-danger">{{ __('Disable last years events') }}</x-default-button>
                </div>
            @endif


            <div x-data="{
                        open:false,
                    }" class="relative inline-block text-left" @click.outside="open = false">
                <div>
                    <button type="button" x-ref="exportDropdownButton"
                            class="inline-flex w-full justify-center items-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            @click.stop="open = !open">
                        <i class="fa-solid fa-file-export"></i> Export
                        <i class="fa-solid fa-chevron-down text-gray-400 transition"
                           :class="open ? 'rotate-180' : ''"></i>
                    </button>
                </div>

                <div x-cloak x-show="open" x-anchor="$refs.exportDropdownButton"
                     class="z-10 mt-2 w-48 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <div class="py-1">
                        <div class="px-4 py-1">
                            <x-button-link class="w-full"
                                           href="{{route('event.list.csv', $eventFilter->toParameterArray())}}"
                                           @click="open=false"
                                           title="Download event list as CSV file">{{ __('CSV List') }}</x-button-link>
                        </div>
                        <div class="px-4 py-1">
                            <x-button-link class="w-full"
                                           href="{{route('event.list.excel', $eventFilter->toParameterArray())}}"
                                           @click="open=false"
                                           title="Download event list as Excel file">{{ __('Excel File') }}</x-button-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endauth
</div>
