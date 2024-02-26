@php
    $hasShowPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_SHOW_PERMISSION);
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_EDIT_PERMISSION);
    /** @var $period \App\Models\Sponsoring\Period */
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <span>{{ __('Sponsoring') }}</span>
            <div class="flex gap-2 items-center">
                <x-dropdown>
                    <x-slot name="trigger">
                        <x-default-button class="btn-secondary flex gap-2"
                                          type="button" aria-expanded="true" aria-haspopup="true">
                            {{__("Basic data")}}
                            <i class="fa-solid fa-caret-down"></i>
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
                    </x-slot>
                </x-dropdown>
                @if($hasEditPermission)
                        <x-button-link class="btn-success"
                                       href="{{route('sponsoring.period.create')}}"
                                       title="Create a new period">{{__("New period")}}</x-button-link>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="bg-white shadow-sm sm:rounded-lg p-4">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-2">
            @forelse(\App\Models\Sponsoring\Period::query()->orderBy("start", 'desc')->get() as $period)
                <x-sponsoring.period-item :period="$period" :hasShowPermission="$hasShowPermission" :hasEditPermission="$hasEditPermission"/>
            @empty
                <div class="text-gray-600 text-center col-span-full">-- {{__("no periods")}} --</div>
            @endforelse
        </div>
    </div>
</x-backend-layout>
