<div>
    <x-slot name="headline">
        <div class="flex items-center">
            <span>{{ __('Event Statistic') }}</span>
        </div>
    </x-slot>
    <x-livewire.loading/>

    <div class="flex flex-col gap-3 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
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

            <div>selected: {{$selectedYear ?: "null"}}</div>
        @endif
    </div>

</div>
