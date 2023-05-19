<x-backend-layout>
    <x-slot name="headline">
        {{ __('Dashboard') }}
    </x-slot>


    <div class="flex flex-col-reverse lg:grid lg:grid-cols-2 gap-4">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                {{\Illuminate\Support\Facades\App::currentLocale()}}
                @auth
                    {{ __("You're logged in!") }}
                @endauth

                @guest
                    {{ __("You are a guest !!!") }}
                @endguest
            </div>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-dashboard.messages :messages="$messages"/>
        </div>
    </div>
</x-backend-layout>
