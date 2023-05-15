<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Please first set a password before logging in.') }}
    </div>
    <form method="POST">
        @csrf

        <input type="hidden" name="email" value="{{ $user->email }}"/>

        <div>
            <x-input-label for="password">{{ __('Password') }}</x-input-label>

            <x-text-input id="password" type="password"
                          name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <div class="mt-4">
            <x-input-label for="password-confirm">{{ __('Confirm Password') }}</x-input-label>

            <x-text-input id="password-confirm" type="password" name="password_confirmation" required
                          autocomplete="new-password" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button type="submit">
                {{ __('Save password and login') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
