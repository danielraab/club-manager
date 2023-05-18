@auth
    <!-- Info Message -->
    <x-responsive-nav-link :href="route('infoMessage.index')"
                           :active="request()->routeIs('infoMessage.index')">
        {{ __('Info Messages') }}
    </x-responsive-nav-link>

    <!-- User Management -->
    @if(Auth::user()->hasPermission(\App\Models\UserPermission::USER_MANAGEMENT_SHOW_PERMISSION, \App\Models\UserPermission::USER_MANAGEMENT_EDIT_PERMISSION))
        <x-responsive-nav-link :href="route('userManagement.index')"
                               :active="request()->routeIs('userManagement.index')">
            {{ __('User Management') }}
        </x-responsive-nav-link>
    @endif
@endauth
