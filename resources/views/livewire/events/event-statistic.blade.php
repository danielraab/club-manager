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
                    @foreach($availableYears as $year)
                        <option value="{{$year}}">{{$year}}</option>
                    @endforeach
                </select>
        </div>
        <div class="py-4">
            @if($selectedYear)
                @php
                $eventsWithNoType = \App\Models\Event::query()
                    ->where("start", ">=", "$this->selectedYear-01-01 00:00:00")
                    ->where("start", "<=", "$this->selectedYear-12-31 23:59:59")
                    ->whereNull("event_type_id")
                    ->orderBy("start")
                    ->get();
                @endphp
                <h2>{{__("Event statistic for :year", ["year" => $selectedYear])}}</h2>
                <div
                    class="mt-2 mb-4 leading-5 text-slate-500">{{__("Events are sorted under their type.")}}</div>
                <div class="flex justify-center">
                    <ul class="w-fit list-disc">
                        @if($eventsWithNoType->count() > 0)
                            <li>
                                <div class="flex justify-between text-red-800 font-bold">
                                    <span>{{__("With no event type")}}</span>
                                    <span>{{$eventsWithNoType->count()}}</span>
                                </div>
                                <x-events.event-type-statistic-event-list :events="$eventsWithNoType"/>
                            </li>
                        @endif
                        @foreach(\App\Models\EventType::getTopLevelQuery()->get() as $eventType)
                            <x-events.event-type-statistic :eventType="$eventType"/>
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
