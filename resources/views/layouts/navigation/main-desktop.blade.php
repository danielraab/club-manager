@auth
    <!-- Info Message -->
    <x-nav-link :href="route('infoMessage.index')"
                :active="request()->routeIs('infoMessage.index')">
        {{ __('Infos') }}
    </x-nav-link>

    <!-- User Management -->
    @if(Auth::user()->hasPermission(\App\Models\UserPermission::USER_MANAGEMENT_SHOW_PERMISSION, \App\Models\UserPermission::USER_MANAGEMENT_EDIT_PERMISSION))
        <x-nav-link :href="route('userManagement.index')"
                    :active="request()->routeIs('userManagement.index')">
            {{ __('Users') }}
        </x-nav-link>
    @endif
@endauth
