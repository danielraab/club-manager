
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

    <!-- User Management -->
    @if(Auth::user()->hasPermission(\App\Models\UserPermission::USER_MANAGEMENT_SHOW_PERMISSION, \App\Models\UserPermission::USER_MANAGEMENT_EDIT_PERMISSION))
        <x-responsive-nav-link :href="route('userManagement.index')"
                               :active="request()->routeIs('userManagement.index')">
            {{ __('User Management') }}
        </x-responsive-nav-link>
    @endif
@endauth
