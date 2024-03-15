
<!-- events -->
<x-nav-link :href="route('event.index')"
            :active="request()->routeIs('event.*')">
    {{ __('Events') }}
</x-nav-link>

@auth
    <!-- news -->
    <x-nav-link :href="route('news.index')"
                :active="request()->routeIs('news.*')">
        {{ __('News') }}
    </x-nav-link>

    <!-- Member -->
    @if(Auth::user()->hasPermission(\App\Models\Member::MEMBER_SHOW_PERMISSION, \App\Models\Member::MEMBER_EDIT_PERMISSION))
        <x-nav-link :href="route('member.index')"
                    :active="request()->routeIs('member.*')">
            {{ __('Members') }}
        </x-nav-link>
    @endif

    <!-- Polls -->
    @if(Auth::user()->hasPermission(\App\Models\AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION, \App\Models\AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION))
        <x-nav-link :href="route('attendancePoll.index')"
                    :active="request()->routeIs('attendancePoll.*')">
            {{ __('Attendance polls') }}
        </x-nav-link>
    @endif

    <!-- Sponsoring -->
    @if(Auth::user()->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_SHOW_PERMISSION, \App\Models\Sponsoring\Contract::SPONSORING_EDIT_PERMISSION))
        <x-nav-link :href="route('sponsoring.index')"
                    :active="request()->routeIs('sponsoring.*')">
            {{ __('Sponsoring') }}
        </x-nav-link>
    @endif

    <!-- User Management -->
    @if(Auth::user()->hasPermission(\App\Models\UserPermission::USER_MANAGEMENT_SHOW_PERMISSION, \App\Models\UserPermission::USER_MANAGEMENT_EDIT_PERMISSION))
        <x-nav-link :href="route('userManagement.index')"
                    :active="request()->routeIs('userManagement.*')">
            {{ __('Users') }}
        </x-nav-link>
    @endif
@endauth
