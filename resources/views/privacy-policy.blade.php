<x-backend-layout>
    <x-slot name="headline">
            {{ __('Privacy policy') }}
    </x-slot>

    <div class="py-6">
        <div class="bg-white shadow-sm sm:rounded-lg sm:p-4 p-2">
            {!! App\Models\Configuration::getString(App\Models\ConfigurationKey::PRIVACY_POLICY_TEXT) !!}
        </div>
    </div>
</x-backend-layout>
