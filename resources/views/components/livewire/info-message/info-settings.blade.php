@props(["info" => null])
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Info Settings') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Enter settings for info message.") }}
        </p>
    </header>

    <div class="mt-6">

        <!-- Enabled -->
        <div class="mt-4 ml-3">
            <x-input-checkbox id="enabled" name="enabled" wire:model.defer="info.enabled"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Enabled') }}
            </x-input-checkbox>
        </div>


        <!-- only internal -->
        <div class="mt-4 ml-3">
            <x-input-checkbox id="logged_in_only" name="logged_in_only" wire:model.defer="info.logged_in_only"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Only for logged in user') }}
            </x-input-checkbox>
        </div>

        <div class="mt-4">
            <x-input-label for="display_until" :value="__('Display until')"/>
            <x-input-datetime id="display_until" name="display_until" type="text" class="mt-1 block w-full"
                              wire:model.defer="display_until"
                              required autofocus autocomplete="display_until"/>
            @error('display_until')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        @if($info && $info->creator)
            <div  class="text-gray-500 mt-20 ml-3">
                <i class="fa-regular fa-square-plus"></i>
                <span title="{{__("Creator")}}">{{$info->creator->name}}</span> -
                <span title="{{__("Created at")}}">{{$info->created_at?->isoFormat('D. MMM YYYY')}}</span>
            </div>
        @endif

        @if($info && $info->lastUpdater)
            <div  class="text-gray-500 mt-1 ml-3">
                <i class="fa-solid fa-pencil"></i>
                <span title="{{__("Last updater")}}">{{ $info->lastUpdater->name }}</span> -
                <span title="{{__("Updated at")}}">{{$info->updated_at?->isoFormat('D. MMM YYYY')}}</span>
            </div>
        @endif

    </div>
</section>
