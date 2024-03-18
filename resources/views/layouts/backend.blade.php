<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            @if(isset($headline))
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $headline }}
                </h2>
            @endif
            @if(isset($headerBtn))
                {{ $headerBtn }}
            @endif
        </div>
    </x-slot>

        <div class="py-6">
        <x-notification-messages/>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </div>
</x-app-layout>
