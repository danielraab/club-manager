<x-app-layout>
    <x-slot name="title">
        @if(isset($titlePostfix))
            {{ ($title ?? $appName) . ' - ' . $titlePostfix }}
        @else
            {{ $title ?? $appName }}
        @endif
    </x-slot>
    <div class="min-h-[80vh] flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <x-notification-messages/>
        <div class="flex flex-col items-center">
            <a href="/">
                <x-application-logo class="h-20 fill-current text-gray-500"/>
            </a>
            @if(strlen(trim($guestLayoutText = \App\Models\Configuration::getString(\App\Models\ConfigurationKey::GUEST_LAYOUT_TEXT))) > 0)
                <div class="mt-3">
                    <span>{{$guestLayoutText}}</span>
                </div>
            @endif
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</x-app-layout>
