
<!-- Settings Dropdown -->
<div class="hidden lg:flex gap-2 ml-6">
    <x-web-push-notification-icon />
    @auth

        <div x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false" class="inline-flex items-center">
            <div @click="open = !open" x-ref="userNavBtn"
                 class="btn inline-flex items-center px-3 py-2 text-sm leading-4 font-medium text-gray-500 hover:text-gray-700 hover:cursor-pointer focus:outline-none">
                <div>{{ Auth::user()->name }}</div>

                <div class="ml-1">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>

            <div x-show="open" x-cloak class="bg-white py-1 rounded-md border-gray-900 shadow-md ring-1 text-gray-700 ring-black ring-opacity-5"
                 x-anchor.bottom-end="$refs.userNavBtn" x-collapse>
                @if(Auth::user()->hasPermission(\App\Models\UserPermission::ADMIN_USER_PERMISSION))
                    <a href="{{route('settings')}}" class="block w-full px-4 py-1 my-1 hover:bg-gray-100">
                        {{ __('Settings') }}
                    </a>
                    <hr>
                @endif
                <a href="{{route('profile.edit')}}" class="block w-full px-4 py-1 my-1 hover:bg-gray-100">
                    {{ __('Profile') }}
                </a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button class="text-left w-full px-4 py-1 my-1 hover:bg-gray-100">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    @endauth
    @guest
        <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
            {{ __('Login') }}
        </x-nav-link>
    @endguest
</div>
