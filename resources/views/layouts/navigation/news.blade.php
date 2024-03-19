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
</x-nav-dropdown>
