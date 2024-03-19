@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\News::NEWS_EDIT_PERMISSION);
@endphp
<x-nav-dropdown>
    <x-slot name="mainLink">
        <x-responsive-nav-link :href="route('news.index')" iconClasses="fa-solid fa-bullhorn"
                               :active="request()->routeIs('news.*')">
            {{ __('News Management') }}
        </x-responsive-nav-link>
    </x-slot>
    @if($hasEditPermission)
        <x-responsive-nav-link href="{{route('news.create')}}" title="Create new event"
                               iconClasses="fa-solid fa-plus"
                               :active="request()->routeIs('news.create')">
            {{__("Create new news")}}
        </x-responsive-nav-link>
    @endif
</x-nav-dropdown>
