@props(["eventForm" => null])
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Event Settings') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Enter settings for event.") }}
        </p>
    </header>

    <div class="mt-6">
        {{-- event type--}}
        <div class="my-4">
            <x-input-label for="type" :value="__('Type')"/>
            <select id="type" name="type"
                    wire:model="eventForm.type"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                <option value=""></option>
                @foreach(\App\Models\EventType::getTopLevelQuery()->get() as $eventType)
                    <x-events.event-type-select-option :eventType="$eventType"/>
                @endforeach
            </select>
            @error('eventForm.type')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <!-- Enabled -->
        <div class="ml-3">
            <x-input-checkbox id="enabled" name="enabled"
                              wire:model="eventForm.enabled"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Enabled') }}<i class="fa-solid fa-circle-info text-gray-500 ml-2"
                                      title="{{__("Disabled events are not shown on the calendar export neither the json export.")}}"></i>
            </x-input-checkbox>
        </div>


        <!-- only internal -->
        <div class="mt-4 ml-3">
            <x-input-checkbox id="logged_in_only" name="logged_in_only"
                              wire:model="eventForm.logged_in_only"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Only for logged in user') }}
            </x-input-checkbox>
        </div>

        {{--        start--}}
        <div class="mt-4">
            <x-input-label for="start" :value="__('Start')"/>
            <x-input-datetime id="start" name="start" type="text" class="mt-1 block w-full"
                              wire:model.blur="eventForm.start"
                              required autofocus autocomplete="start"/>
            @error('eventForm.start')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        {{--        end--}}
        <div class="mt-4">
            <x-input-label for="end" :value="__('End')"/>
            <x-input-datetime id="end" name="end" type="text" class="mt-1 block w-full"
                              wire:model.blur="eventForm.end"
                              required autofocus autocomplete="end"/>
            @error('eventForm.end')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>


        <!-- whole day -->
        <div class="mt-4 mb-4 ml-3">
            <x-input-checkbox id="whole_day" name="whole_day" wire:model="eventForm.whole_day"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Whole day') }} <i class="fa-solid fa-circle-info text-gray-500 ml-2"
                                         title="{{__("The time will not be shown.")}}"></i>
            </x-input-checkbox>
        </div>


        @if($eventForm?->event?->created_at)
            <div class="text-gray-500 mt-3 ml-3">
                <i class="fa-regular fa-square-plus"></i>
                <span title="{{__("Creator")}}">{{$eventForm->event?->creator?->name}}</span> -
                <span title="{{__("Created at")}}">{{$eventForm->event?->created_at->formatDateTimeWithSec()}}</span>
            </div>
        @endif

        @if($eventForm?->event?->updated_at)
            <div class="text-gray-500 mt-2 ml-3">
                <i class="fa-solid fa-pencil"></i>
                <span title="{{__("Last updater")}}">{{ $eventForm->event?->lastUpdater?->name }}</span> -
                <span title="{{__("Updated at")}}">{{$eventForm->event?->updated_at->formatDateTimeWithSec()}}</span>
            </div>
        @endif

    </div>
</section>
