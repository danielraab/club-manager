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
            <x-input id="title" name="title" type="text" class="mt-1 block w-full"
                          wire:model="newsForm.title"
                          required autofocus autocomplete="title"/>
            @error('newsForm.title')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
        <div class="my-3" wire:ignore x-init="initNews()">
            @vite(['resources/js/trix.umd.min.js', 'resources/css/trix.css'])
            <script>
                function initNews() {
                    const trixEditor = document.getElementById("contentEditor")
                    addEventListener("trix-before-initialize", function (event) {
                        Trix.config.blockAttributes.heading1.tagName = "h2";
                    });
                    addEventListener("trix-blur", function (event) {
                        console.log("trixEditor: ", trixEditor.value);
                    @this.set('newsForm.content', trixEditor.value);
                    });
                }
            </script>

            <x-input-label for="content" :value="__('Content')"/>

            <input id="contentInput" type="hidden" name="content" wire:model="newsForm.content">
            <trix-editor id="contentEditor" input="contentInput" class="w-full min-h-[200px]"></trix-editor>

            @error('newsForm.content')
            <x-input-error class="mt-2" :messages="$message"/>@enderror

        </div>
    </div>
</section>
