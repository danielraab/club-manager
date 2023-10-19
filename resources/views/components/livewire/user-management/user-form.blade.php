<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('User Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Enter account profile information and email address.") }}
        </p>
    </header>

    <div class="mt-6">
        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                          wire:model="userForm.name"
                          required autofocus autocomplete="name"/>
            @error('userForm.name') <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="my-3">
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                          wire:model="userForm.email" required autocomplete="username"/>
            @error('userForm.email') <x-input-error class="mt-2" :messages="$message"/>@enderror

        </div>
    </div>
</section>
