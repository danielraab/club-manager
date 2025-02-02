<x-guest-layout>
    <x-slot name="titlePostfix">
        {{__('Login')}}
    </x-slot>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')"/>
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                     autofocus autocomplete="username"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')"/>

            <x-input id="password" class="block mt-1 w-full"
                     type="password"
                     name="password"
                     required autocomplete="current-password"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                   href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button type="submit" class="ml-3 btn btn-primary">
                {{ __('Log in') }}
            </button>
        </div>
    </form>
    <hr class="my-3">
    <div class="flex flex-col items-center gap-2">
        @if(config('services.google.client_id'))
            <a href="{{route('oauth.google.redirect')}}" class="ml-3 btn btn-secondary">
                {{ __('Login with') }}&nbsp;<strong>Google</strong>
            </a>
        @endif
        @if(config('services.authentik.client_id'))
            <a href="{{route('oauth.authentik.redirect')}}" class="ml-3 btn btn-secondary">
                {{ __('Login with')}}&nbsp;<strong>{{config('services.authentik.ip_name')}}</strong>
            </a>
        @endif
    </div>
</x-guest-layout>
