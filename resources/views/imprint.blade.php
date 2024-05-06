<x-backend-layout>
    <x-slot name="headline">
            {{ __('Imprint') }}
    </x-slot>

    <div class="py-6">
        <div class="bg-white shadow-sm sm:rounded-lg sm:p-4">
            {!! App\Models\Configuration::getString(App\Models\ConfigurationKey::IMPRINT_TEXT) !!}
        </div>
    </div>
</x-backend-layout>
