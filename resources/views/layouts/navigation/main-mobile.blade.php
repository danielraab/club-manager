
<!--  events -->
<x-responsive-nav-link :href="route('event.index')"
                       :active="request()->routeIs('event.*')">
    {{ __('Event Management') }}
</x-responsive-nav-link>

@auth
    <!--  news -->
    <x-responsive-nav-link :href="route('news.index')"
                           :active="request()->routeIs('news.*')">
        {{ __('News Management') }}
    </x-responsive-nav-link>

    <!-- Member -->
    @if(Auth::user()->hasPermission(\App\Models\Member::MEMBER_SHOW_PERMISSION, \App\Models\Member::MEMBER_EDIT_PERMISSION))
        <x-responsive-nav-link :href="route('member.index')"
                               :active="request()->routeIs('member.*')">
            {{ __('Members') }}
        </x-responsive-nav-link>
    @endif

    <!-- Polls -->
    @if(Auth::user()->hasPermission(\App\Models\AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION, \App\Models\AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION))
        <x-responsive-nav-link :href="route('attendancePoll.index')"
                               :active="request()->routeIs('attendancePoll.*')">
            {{ __('Attendance polls') }}
        </x-responsive-nav-link>
    @endif

    <!-- Polls -->
    @if(Auth::user()->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_SHOW_PERMISSION, \App\Models\Sponsoring\Contract::SPONSORING_EDIT_PERMISSION))
        <x-responsive-nav-link :href="route('sponsoring.index')"
                               :active="request()->routeIs('sponsoring.*')">
            {{ __('Sponsoring') }}
        </x-responsive-nav-link>
    @endif

    <!-- User Management -->
    @if(Auth::user()->hasPermission(\App\Models\UserPermission::USER_MANAGEMENT_SHOW_PERMISSION, \App\Models\UserPermission::USER_MANAGEMENT_EDIT_PERMISSION))
        <x-responsive-nav-link :href="route('userManagement.index')"
                               :active="request()->routeIs('userManagement.*')">
            {{ __('User management') }}
        </x-responsive-nav-link>
    @endif
@endauth
