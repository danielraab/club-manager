@props(["newsForm" => null])
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('News Settings') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Enter settings for news.") }}
        </p>
    </header>

    <div class="mt-6">

        <!-- Enabled -->
        <div class="mt-4 ml-3">
            <x-input-checkbox id="enabled" name="enabled"
                              wire:model="newsForm.enabled"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Enabled') }}
            </x-input-checkbox>
        </div>


        <!-- only internal -->
        <div class="mt-4 ml-3">
            <x-input-checkbox id="logged_in_only" name="logged_in_only"
                              wire:model="newsForm.logged_in_only"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Only for logged in user') }}
            </x-input-checkbox>
        </div>

        <div class="mt-4">
            <x-input-label for="display_until" :value="__('Display until')"/>
            <x-input-date-time id="display_until" wire:model.blur="newsForm.display_until"
                               class="mt-1 block w-full"
                               required />
            @error('newsForm.display_until')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        @if($newsForm?->news?->creator)
            <div  class="text-gray-500 mt-20 ml-3">
                <i class="fa-regular fa-square-plus"></i>
                <span title="{{__("Creator")}}">{{$newsForm?->news?->creator->name}}</span> -
                <span title="{{__("Created at")}}">{{$newsForm?->news?->created_at?->formatDateTimeWithSec()}}</span>
            </div>
        @endif

        @if($newsForm?->news?->lastUpdater)
            <div  class="text-gray-500 mt-1 ml-3">
                <i class="fa-solid fa-pencil"></i>
                <span title="{{__("Last updater")}}">{{ $newsForm?->news?->lastUpdater->name }}</span> -
                <span title="{{__("Updated at")}}">{{$newsForm?->news?->updated_at?->formatDateTimeWithSec()}}</span>
            </div>
        @endif

    </div>
</section>
