<x-section-card>

    <header class="mb-3">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Privacy policy') }}
        </h2>
    </header>

    <x-livewire.loading/>
    <div
        class="rounded-md bg-white p-4 text-[0.8125rem] leading-6 text-slate-900 shadow-xl shadow-black/5 ring-1 ring-slate-700/10">
        <div class="my-3" wire:ignore x-init="initPrivacyPolicyText()">
            @vite(['resources/js/trix.umd.min.js', 'resources/css/trix.css'])
            <script>
                function initPrivacyPolicyText() {
                    const trixEditor = document.getElementById("privacyPolicyTextEditor")
                    addEventListener("trix-before-initialize", function (event) {
                        Trix.config.blockAttributes.heading1.tagName = "h2";
                    });
                    addEventListener("trix-blur", function (event) {
                        @this.set('privacyPolicyText', trixEditor.value);
                    });
                }
            </script>
            <input id="privacyPolicyText" type="hidden" name="privacyPolicyText" wire:model="privacyPolicyText">
            <trix-editor id="privacyPolicyTextEditor" input="privacyPolicyText" class="w-full min-h-[300px]"></trix-editor>

            @error('privacyPolicyText') <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
    </div>
</x-section-card>
