@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Event::EVENT_EDIT_PERMISSION) ?? false;
@endphp
<x-nav-dropdown>
    <x-slot name="mainLink">
        <x-responsive-nav-link :href="route('event.index')" iconClasses="fa-regular fa-calendar"
                               :active="request()->routeIs('event.*')">
            {{ __('Event Management') }}
        </x-responsive-nav-link>
    </x-slot>
    @if($hasEditPermission)
        <x-responsive-nav-link href="{{route('event.create')}}" title="Create new event"
                               :active="request()->routeIs('event.create')">
            {{__("Create new event")}}
        </x-responsive-nav-link>
        <x-responsive-nav-link href="{{route('event.type.index')}}" title="Show event type list"
                               :active="request()->routeIs('event.type.index')">
            {{__("Event Types")}}
        </x-responsive-nav-link>
    @endif
    @auth
        <x-responsive-nav-link href="{{route('event.statistic')}}" title="Calendar"
                               :active="request()->routeIs('event.statistic')">
            <i class="fa-solid fa-chart-simple mr-1"></i>
            {{__("Statistic")}}
        </x-responsive-nav-link>
    @endauth
    <x-responsive-nav-link href="{{route('event.calendar')}}"
                           :active="request()->routeIs('event.calendar')">
        <i class="fa-solid fa-calendar-days mr-1"></i>
        {{ __('Calendar') }}
    </x-responsive-nav-link>
</x-nav-dropdown>
