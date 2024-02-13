@php
    /** @var $backer \App\Models\Sponsoring\Backer */
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <span>{{ __('Sponsoring') }}</span>
            <x-dropdown>
                <x-slot name="trigger">
                    <x-default-button class="btn-secondary"
                        type="button" aria-expanded="true" aria-haspopup="true">
                        {{__("Elements")}}
                        <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                             aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </x-default-button>
                </x-slot>
                <x-slot name="content">
                    <a href="{{route("sponsoring.backer.index")}}"
                       class="text-gray-700 block px-4 py-2 text-sm"
                       role="menuitem" tabindex="-1"
                       id="menu-item-0">{{__("backers")}}</a>
                    <a href="{{route("sponsoring.ad-option.index")}}"
                       class="text-gray-700 block px-4 py-2 text-sm"
                       role="menuitem" tabindex="-1"
                       id="menu-item-1">{{__("ad options")}}</a>
                    <a href="{{route("sponsoring.package.index")}}"
                       class="text-gray-700 block px-4 py-2 text-sm"
                       role="menuitem" tabindex="-1"
                       id="menu-item-2">{{__("packages")}}</a>
                    <a href="#"
                       class="text-gray-700 block px-4 py-2 text-sm"
                       role="menuitem" tabindex="-1"
                       id="menu-item-2">{{__("periods")}}</a>
                    <a href="#"
                       class="text-gray-700 block px-4 py-2 text-sm"
                       role="menuitem" tabindex="-1"
                       id="menu-item-2">{{__("contracts")}}</a>
                </x-slot>
            </x-dropdown>
        </div>
    </x-slot>

    <div class="bg-white shadow-sm sm:rounded-lg p-4">

    </div>
</x-backend-layout>
