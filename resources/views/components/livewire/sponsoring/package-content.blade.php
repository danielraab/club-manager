<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Package') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Enter basic information of the package.") }}
        </p>
    </header>

    <div class="mt-6">
        <div class="flex gap-5">
            <x-input-checkbox id="enabled" name="enabled" wire:model="packageForm.enabled"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Is enabled') }} <i class="fa-solid fa-circle-info text-gray-500 ml-2"
                                          title="{{__("The package is enabled.")}}"></i>
            </x-input-checkbox>
            <x-input-checkbox id="is_official" name="is_official" wire:model="packageForm.is_official"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Is official') }} <i class="fa-solid fa-circle-info text-gray-500 ml-2"
                                           title="{{__("The package is official.")}}"></i>
            </x-input-checkbox>
        </div>

        <div class="mt-3">
            <x-input-label for="title" :value="__('Title')"/>
            <x-input id="title" name="title" type="text" class="mt-1 block w-full"
                          wire:model="packageForm.title"
                          required autofocus autocomplete="title"/>
            @error('packageForm.title')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="mt-3">
            <x-input-label for="description" :value="__('Description')"/>
            <x-textarea id="description" name="description" type="text" class="mt-1 block w-full"
                        wire:model="packageForm.description"
                        autofocus autocomplete="description"/>
            @error('packageForm.description')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="mt-3">
            <x-input-label for="price" :value="__('Price')"/>
            <x-input-currency id="price" name="price" class="mt-1 block w-full"
                              wire:model="packageForm.price"
                              autofocus autocomplete="price"/>
            @error('packageForm.price')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
    </div>
</section>
