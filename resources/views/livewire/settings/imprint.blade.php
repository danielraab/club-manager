<x-section-card>

    <header class="mb-3">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Imprint') }}
        </h2>
    </header>

    <x-livewire.loading/>
    <div
        class="rounded-md bg-white p-4 text-[0.8125rem] leading-6 text-slate-900 shadow-xl shadow-black/5 ring-1 ring-slate-700/10">
        <div class="flex items-center justify-between border-slate-400/20 py-3">
            <x-input-label for="imprintLinkName" :value="__('Link Name')"/>
            <div class="flex flex-col justify-end gap-2 items-center">
                <x-input type="text" id="imprintLinkName" wire:model.blur="linkName"/>
            </div>
        </div>
        <div class="my-3" wire:ignore x-init="initImprintText()">
            @vite(['resources/js/trix.umd.min.js', 'resources/css/trix.css'])
            <script>
                function initImprintText() {
                    const trixEditor = document.getElementById("imprintTextEditor")
                    addEventListener("trix-before-initialize", function (event) {
                        Trix.config.blockAttributes.heading1.tagName = "h2";
                    });
                    addEventListener("trix-blur", function (event) {
                        @this.set('imprintText', trixEditor.value);
                    });
                }
            </script>
            <x-input-label for="imprintTextEditor" :value="__('Text')"/>
            <input id="imprintText" type="hidden" name="imprintText" wire:model="imprintText">
            <trix-editor id="imprintTextEditor" input="imprintText" class="w-full min-h-[300px]"></trix-editor>

            @error('imprintText') <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
    </div>
</x-section-card>
