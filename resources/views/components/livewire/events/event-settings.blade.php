@props(["event" => null])
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

        <!-- Enabled -->
        <div class="mt-4 ml-3">
            <x-input-checkbox id="enabled" name="enabled" wire:model.defer="event.enabled"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Enabled') }}
            </x-input-checkbox>
        </div>


        <!-- only internal -->
        <div class="mt-4 ml-3">
            <x-input-checkbox id="logged_in_only" name="logged_in_only" wire:model.defer="event.logged_in_only"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Only for logged in user') }}
            </x-input-checkbox>
        </div>


        <div class="mt-4">
            <x-input-label for="start" :value="__('Start')"/>
            <x-input-datetime id="start" name="start" type="text" class="mt-1 block w-full"
                              wire:model.defer="start"
                              required autofocus autocomplete="start"/>
            @error('start')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>


        <div class="mt-4">
            <x-input-label for="end" :value="__('End')"/>
            <x-input-datetime id="end" name="end" type="text" class="mt-1 block w-full"
                              wire:model.defer="end"
                              required autofocus autocomplete="end"/>
            @error('end')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>


        <!-- whole day -->
        <div class="mt-4 ml-3">
            <x-input-checkbox id="whole_day" name="whole_day" wire:model.defer="event.whole_day"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Whole day') }}
            </x-input-checkbox>
        </div>


        @if($event && $event->creator)
            <div  class="text-gray-500 mt-20 ml-3">
                <i class="fa-regular fa-square-plus"></i>
                <span title="{{__("Creator")}}">{{$event->creator->name}}</span> -
                <span title="{{__("Created at")}}">{{$event->created_at?->isoFormat('D. MMM YYYY')}}</span>
            </div>
        @endif

        @if($event && $event->lastUpdater)
            <div  class="text-gray-500 mt-1 ml-3">
                <i class="fa-solid fa-pencil"></i>
                <span title="{{__("Last updater")}}">{{ $event->lastUpdater->name }}</span> -
                <span title="{{__("Updated at")}}">{{$event->updated_at?->isoFormat('D. MMM YYYY')}}</span>
            </div>
        @endif

    </div>
</section>
