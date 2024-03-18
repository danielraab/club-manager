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

@auth
    <!--  news -->
    <x-responsive-nav-link :href="route('news.index')" iconClasses="fa-solid fa-bullhorn"
                           :active="request()->routeIs('news.*')">
        {{ __('News Management') }}
    </x-responsive-nav-link>

    <!-- Member -->
    @if(Auth::user()->hasPermission(\App\Models\Member::MEMBER_SHOW_PERMISSION, \App\Models\Member::MEMBER_EDIT_PERMISSION))
        <x-responsive-nav-link :href="route('member.index')" iconClasses="fa-solid fa-users"
                               :active="request()->routeIs('member.*')">
            {{ __('Members') }}
        </x-responsive-nav-link>
    @endif

    <!-- Polls -->
    @if(Auth::user()->hasPermission(\App\Models\AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION, \App\Models\AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION))
        <x-responsive-nav-link :href="route('attendancePoll.index')" iconClasses="fa-solid fa-clipboard-user"
                               :active="request()->routeIs('attendancePoll.*')">
            {{ __('Attendance polls') }}
        </x-responsive-nav-link>
    @endif

    <!-- sponsoring -->
    @if(Auth::user()->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_SHOW_PERMISSION, \App\Models\Sponsoring\Contract::SPONSORING_EDIT_PERMISSION))
        <x-responsive-nav-link :href="route('sponsoring.index')" iconClasses="fa-solid fa-file-contract"
                               :active="request()->routeIs('sponsoring.*')">
            {{ __('Sponsoring') }}
        </x-responsive-nav-link>
    @endif

    <!-- User Management -->
    @if(Auth::user()->hasPermission(\App\Models\UserPermission::USER_MANAGEMENT_SHOW_PERMISSION, \App\Models\UserPermission::USER_MANAGEMENT_EDIT_PERMISSION))
        <x-responsive-nav-link :href="route('userManagement.index')" iconClasses="fa-solid fa-users-gear"
                               :active="request()->routeIs('userManagement.*')">
            {{ __('User management') }}
        </x-responsive-nav-link>
    @endif
@endauth
