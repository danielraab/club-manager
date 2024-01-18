<div>
    <x-slot name="headline">
        <div class="flex items-center">
            <span>{{ __('Event Statistic') }}</span>
        </div>
    </x-slot>
    <x-livewire.loading/>

    <div class="flex flex-col gap-3 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
        <div class="border-b py-4 flex justify-center">
            @if(empty($availableYears))
                <div>{{__("no data available")}}</div>
            @else
                <label for="selectedYear">Year:</label>
                <select name="selectedYear" id="selectedYear" wire:model.lazy="selectedYear"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ml-3 py-1 text-sm"
                >
                    <option value=""></option>
                    @foreach($availableYears as $year)
                        <option value="{{$year}}">{{$year}}</option>
                    @endforeach
                </select>
        </div>
        <div class="py-4">
            @if($eventTypes)
                <h2>{{__("Event statistic for :year", ["year" => $selectedYear])}}</h2>
                <div
                    class="mt-2 mb-4 leading-5 text-slate-500">{{__("Events are sorted under their type.")}}</div>
                <div class="flex justify-center">
                    <ul class="w-fit list-disc">
                        @foreach($eventTypes->get() as $eventType)
                            @php
                                /** @var \App\Models\EventType $eventType */
                            @endphp
                            <li>
                                <div class="flex justify-between">
                                    <span>{{$eventType->title}}</span>
                                    <span>{{$eventType->events->count()}}</span>
                                </div>
                                <ul class="my-2 mx-5 list-[circle]">
                                    @foreach($eventType->events as $event)
                                        @php
                                            /** @var \App\Models\Event $event */
                                        @endphp
                                        <li>{{$event->start->formatDateOnly()}} - {{$event->title}}</li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="text-center">please select a year</div>
            @endif
        </div>
        @endif
    </div>

</div>
