<x-backend-layout>
    <x-slot name="headline">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="p-6 text-gray-900">
        @auth
            {{ __("You're logged in!") }}
        @endauth

        @guest
            {{ __("You are a guest !!!") }}
        @endguest
    </div>
</x-backend-layout>
