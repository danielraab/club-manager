<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Poll basics') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Enter title and short description for the poll.") }}
        </p>
    </header>

    <div class="mt-6">
        <div>
            <x-input-label for="title" :value="__('Title')"/>
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                          wire:model.defer="poll.title"
                          required autofocus autocomplete="title"/>
            @error('poll.title')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="my-3">
            <x-input-label for="description" :value="__('Description')"/>
            <x-textarea id="description" name="description" class="mt-1 block w-full min-h-[200px]"
                        wire:model.defer="poll.description" required autocomplete="description"/>
            @error('poll.description')
            <x-input-error class="mt-2" :messages="$message"/>@enderror

        </div>


        <!-- Enabled -->
        <div class="mt-4 ml-3">
            <x-input-checkbox id="enabled" name="enabled" wire:model.defer="poll.enabled"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Enabled') }}
            </x-input-checkbox>
        </div>

        <!-- allow_anonymous_vote -->
        <div class="mt-4 ml-3">
            <x-input-checkbox id="allow_anonymous_vote" name="allow_anonymous_vote"
                              wire:model.defer="poll.allow_anonymous_vote"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Allow anonymous votes') }}
            </x-input-checkbox>
        </div>


        <div class="mt-4">
            <x-input-label for="closing_at" :value="__('Closing at')"/>
            <x-input-datetime id="closing_at" name="closing_at" type="text" class="mt-1 block w-full"
                              wire:model.defer="closing_at"
                              required autofocus autocomplete="closing_at"/>
            @error('closing_at')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

    </div>
</section>
