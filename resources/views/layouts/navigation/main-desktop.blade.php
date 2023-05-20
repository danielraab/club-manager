@auth
    <!-- news -->
    <x-nav-link :href="route('news.index')"
                :active="request()->routeIs('news.index')">
        {{ __('News') }}
    </x-nav-link>

    <!-- User Management -->
    @if(Auth::user()->hasPermission(\App\Models\UserPermission::USER_MANAGEMENT_SHOW_PERMISSION, \App\Models\UserPermission::USER_MANAGEMENT_EDIT_PERMISSION))
        <x-nav-link :href="route('userManagement.index')"
                    :active="request()->routeIs('userManagement.index')">
            {{ __('Users') }}
        </x-nav-link>
    @endif
@endauth
