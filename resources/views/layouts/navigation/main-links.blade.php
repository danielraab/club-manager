@include('layouts.navigation.events')

@auth
    <!--  news -->
    @include('layouts.navigation.news')

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
