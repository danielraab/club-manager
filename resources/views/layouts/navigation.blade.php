<nav x-data="{ open: false, alwaysOpen: window.innerWidth > 1278}" class="" @click.outside.stop="open = false"
     x-on:resize.window="alwaysOpen = window.innerWidth > 1278">
    <button @click="open = true" x-show="!alwaysOpen"
            class="xl:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path class="inline-flex"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>


    <!-- Responsive Navigation Menu -->
    <div x-show="open || alwaysOpen" x-cloak>
        <div class="flex fixed left-0 top-0 bottom-0">
            <div x-show="!alwaysOpen" class="fixed inset-0 bg-gray-800 opacity-90 z-[90]"></div>
            <div class="flex flex-col bg-white border-r p-5 min-w-[310px] z-[100]"
                 @click.outside="open = false">

                <!-- Logo -->
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800"/>
                </a>
                <div class="space-y-1 mt-3 overflow-y-auto">
                    <x-responsive-nav-link iconClasses="fa-solid fa-house"
                        :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <hr>
                    @include("layouts.navigation.main-links")
                    <hr>
                    @include("layouts.navigation.user-settings")
                </div>
                <div class="mt-auto">
                    <hr>
                    <div class="my-2 flex items-center justify-between">
                        @guest
                            <x-responsive-nav-link :href="route('login')" iconClasses="fa-solid fa-arrow-right-to-bracket">
                                {{ __('Login') }}
                            </x-responsive-nav-link>
                        @endguest
                        @auth
                            <div>
                                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                            <div>
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button type="submit" class="btn btn-secondary text-lg" title="{{ __('Log Out') }}">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                    </button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
            <button x-show="!alwaysOpen" @click="open = false" class="flex m-3 z-[100]">
                <i class="fa-solid fa-xmark text-xl text-white"></i>
            </button>
        </div>

    </div>
</nav>
