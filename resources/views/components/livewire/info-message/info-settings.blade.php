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
            <x-input-checkbox id="only_internal" name="only_internal" wire:model.defer="info.only_internal"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Only internal') }}
            </x-input-checkbox>
        </div>

        <div class="mt-4">
            <x-input-label for="on_dasboard_unitl" :value="__('On dashboard until')"/>
            <x-input-datetime id="on_dasboard_unitl" name="on_dasboard_unitl" type="text" class="mt-1 block w-full" wire:model.defer="info.on_dasboard_unitl"
                          required autofocus autocomplete="on_dasboard_unitl"/>
            @error('info.on_dasboard_unitl')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

    </div>
</section>
