
<!--  events -->
<x-responsive-nav-link :href="route('event.index')"
                       :active="request()->routeIs('event.index')">
    {{ __('Event Management') }}
</x-responsive-nav-link>

@auth
    <!--  news -->
    <x-responsive-nav-link :href="route('news.index')"
                           :active="request()->routeIs('news.index')">
        {{ __('News Management') }}
    </x-responsive-nav-link>

    <!-- Member -->
    @if(Auth::user()->hasPermission(\App\Models\Member::MEMBER_SHOW_PERMISSION, \App\Models\Member::MEMBER_EDIT_PERMISSION))
        <x-responsive-nav-link :href="route('member.index')"
                               :active="request()->routeIs('member.index')">
            {{ __('Members') }}
        </x-responsive-nav-link>
    @endif

    <!-- Polls -->
    @if(Auth::user()->hasPermission(\App\Models\AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION, \App\Models\AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION))
        <x-responsive-nav-link :href="route('member.index')"
                               :active="request()->routeIs('member.index')">
            {{ __('Members') }}
        </x-responsive-nav-link>
    @endif

    <!-- User Management -->
    @if(Auth::user()->hasPermission(\App\Models\UserPermission::USER_MANAGEMENT_SHOW_PERMISSION, \App\Models\UserPermission::USER_MANAGEMENT_EDIT_PERMISSION))
        <x-responsive-nav-link :href="route('attendancePoll.index')"
                               :active="request()->routeIs('attendancePoll.index')">
            {{ __('Attendance polls') }}
        </x-responsive-nav-link>
    @endif
@endauth
