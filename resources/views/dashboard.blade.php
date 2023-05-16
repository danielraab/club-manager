<x-backend-layout>
    <x-slot name="headline">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            @auth
                {{ __("You're logged in!") }}
            @endauth

            @guest
                {{ __("You are a guest !!!") }}
            @endguest
        </div>
    </div>
</x-backend-layout>
