@php
    $hasShowPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_SHOW_PERMISSION, \App\Models\Sponsoring\Contract::SPONSORING_EDIT_PERMISSION);
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_EDIT_PERMISSION);
@endphp


@if($hasShowPermission)
    <x-nav-dropdown>
        <x-slot name="mainLink">
            <x-responsive-nav-link href="{{route('sponsoring.index')}}"
                                   iconClasses="fa-solid fa-file-contract"
                                   :active="request()->routeIs('sponsoring.*')">
                {{ __('Sponsoring') }}
            </x-responsive-nav-link>
        </x-slot>
        @if($hasEditPermission)
            <x-responsive-nav-link href="{{route('sponsoring.period.create')}}"
                                   iconClasses="fa-solid fa-plus"
                                   :active="request()->routeIs('sponsoring.period.create')"
                                   title="Create a new period">
                {{__("New period")}}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{route('sponsoring.backer.index')}}"
                                   :active="request()->routeIs('sponsoring.backer.index')"
                                   iconClasses="fa-solid fa-industry"
                                   title="Backer overview">
                {{__("backers")}}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{route('sponsoring.ad-option.index')}}"
                                   :active="request()->routeIs('sponsoring.ad-option.index')"
                                   iconClasses="fa-solid fa-rectangle-ad"
                                   title="Ad option overview">
                {{__("ad options")}}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{route('sponsoring.package.index')}}"
                                   :active="request()->routeIs('sponsoring.package.index')"
                                   iconClasses="fa-solid fa-cube"
                                   title="Package overview">
                {{__("packages")}}
            </x-responsive-nav-link>
        @endif
    </x-nav-dropdown>

@endif
