<x-backend-layout>
    <x-slot name="headline">
            {{ __('Settings') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <livewire:settings.events />
                <livewire:settings.polls />
            </div>
        </div>
    </div>
</x-backend-layout>
