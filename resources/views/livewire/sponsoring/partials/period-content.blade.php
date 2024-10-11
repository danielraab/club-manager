<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Period') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Enter basic information of the period.") }}
        </p>
    </header>

    <div class="mt-6">
        <div>
            <x-input-label for="title" :value="__('Title')"/>
            <x-input id="title" name="title" type="text" class="mt-1 block w-full"
                          wire:model="periodForm.title"
                          required autofocus autocomplete="title"/>
            @error('periodForm.title')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="mt-3">
            <x-input.textarea
                id="description"
                autocomplete="description"
                :label="__('Description')"
                class="w-full"
                wire:model="periodForm.description"
                errorBag="periodForm.description"
            />
        </div>

        <div class="mt-3">
            <x-input-label for="start" :value="__('Start')"/>
            <x-input type="date" id="start" name="start" class="mt-1 block w-full"
                              wire:model="periodForm.start"
                              autofocus autocomplete="start"/>
            @error('periodForm.start')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="mt-3">
            <x-input-label for="end" :value="__('End')"/>
            <x-input type="date" id="end" name="end" class="mt-1 block w-full"
                              wire:model="periodForm.end"
                              autofocus autocomplete="end"/>
            @error('periodForm.end')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
    </div>
</section>
