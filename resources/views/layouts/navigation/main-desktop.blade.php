
<!-- events -->
<x-nav-link :href="route('event.index')"
            :active="request()->routeIs('event.index')">
    {{ __('Events') }}
</x-nav-link>

@auth
    <!-- news -->
    <x-nav-link :href="route('news.index')"
                :active="request()->routeIs('news.index')">
        {{ __('News') }}
    </x-nav-link>

    <!-- Member -->
    @if(Auth::user()->hasPermission(\App\Models\Member::MEMBER_SHOW_PERMISSION, \App\Models\Member::MEMBER_EDIT_PERMISSION))
        <x-nav-link :href="route('member.index')"
                    :active="request()->routeIs('member.index')">
            {{ __('Members') }}
        </x-nav-link>
    @endif

    <!-- Polls -->
    @if(Auth::user()->hasPermission(\App\Models\AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION, \App\Models\AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION))
        <x-nav-link :href="route('attendancePoll.index')"
                    :active="request()->routeIs('attendancePoll.index')">
            {{ __('Attendance polls') }}
        </x-nav-link>
    @endif

    <!-- User Management -->
    @if(Auth::user()->hasPermission(\App\Models\UserPermission::USER_MANAGEMENT_SHOW_PERMISSION, \App\Models\UserPermission::USER_MANAGEMENT_EDIT_PERMISSION))
        <x-nav-link :href="route('userManagement.index')"
                    :active="request()->routeIs('userManagement.index')">
            {{ __('Users') }}
        </x-nav-link>
    @endif
@endauth
