
<!-- Responsive Settings Options -->
<div>
    @auth
    <div class="mt-3 space-y-1">
        @if(Auth::user()->hasPermission(\App\Models\UserPermission::ADMIN_USER_PERMISSION))
            <x-responsive-nav-link :href="route('settings')" iconClasses="fa-solid fa-screwdriver-wrench">
                {{ __('Settings') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('uploaded-file.list')" iconClasses="fa-solid fa-folder-tree">
                {{ __('Files') }}
            </x-responsive-nav-link>
        @endif
        <x-responsive-nav-link :href="route('profile.edit')" iconClasses="fa-solid fa-user-gear">
            {{ __('Profile') }}
        </x-responsive-nav-link>
    </div>
    @endauth
</div>
