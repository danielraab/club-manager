<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('News') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Enter news title and content.") }}
        </p>
    </header>

    <div class="mt-6">
        <div>
            <x-input-label for="title" :value="__('Title')"/>
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                          wire:model="newsForm.title"
                          required autofocus autocomplete="title"/>
            @error('newsForm.title')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="my-3">
            <x-input-label for="content" :value="__('Content')"/>
            <x-textarea id="content" name="content" class="mt-1 block w-full min-h-[200px]"
                        wire:model="newsForm.content" required autocomplete="content"/>
            @error('newsForm.content')
            <x-input-error class="mt-2" :messages="$message"/>@enderror

        </div>
    </div>
</section>
