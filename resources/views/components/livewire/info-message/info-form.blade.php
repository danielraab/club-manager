<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Info Message') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Enter message title and content.") }}
        </p>
    </header>

    <div class="mt-6">
        <div>
            <x-input-label for="title" :value="__('Title')"/>
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" wire:model.defer="info.title"
                          required autofocus autocomplete="title"/>
            @error('info.title')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="my-3">
            <x-input-label for="content" :value="__('Content')"/>
            <x-textarea id="content" name="content" class="mt-1 block w-full min-h-[250px]"
                        wire:model.defer="info.content" required autocomplete="content"/>
            @error('info.content')
            <x-input-error class="mt-2" :messages="$message"/>@enderror

        </div>




        <!-- Enabled -->
        <div class="mt-4">
            <x-input-checkbox id="enabled" name="enabled" wire:model.defer="info.enabled"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Enabled') }}
            </x-input-checkbox>
        </div>


        <!-- onyl internal -->
        <div class="mt-4">
            <x-input-checkbox id="only_internal" name="only_internal" wire:model.defer="info.only_internal"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Only internal') }}
            </x-input-checkbox>
        </div>
    </div>
</section>
