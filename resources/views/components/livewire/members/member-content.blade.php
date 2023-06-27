<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Member') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Enter basic information of the member.") }}
        </p>
    </header>

    <div class="mt-6">
        <div class="grid grid-cols-2 gap-3">
        <div>
            <x-input-label for="title_pre" :value="__('Prefixed Title')"/>
            <x-text-input id="title_pre" name="title_pre" type="text" class="mt-1 block w-full"
                          wire:model.lazy="member.title_pre"
                          required autofocus autocomplete="title_pre"/>
            @error('member.title_pre')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
        <div>
            <x-input-label for="title_post" :value="__('Postfixed Title')"/>
            <x-text-input id="title_post" name="title_post" type="text" class="mt-1 block w-full"
                          wire:model.lazy="member.title_post"
                          required autofocus autocomplete="title_post"/>
            @error('member.title_post')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
        </div>
        <div>
            <x-input-label for="firstname" :value="__('Firstname')"/>
            <x-text-input id="firstname" name="firstname" type="text" class="mt-1 block w-full"
                          wire:model.lazy="member.firstname"
                          required autofocus autocomplete="firstname"/>
            @error('member.firstname')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
        <div class="mt-3">
            <x-input-label for="lastname" :value="__('Lastname')"/>
            <x-text-input id="lastname" name="lastname" type="text" class="mt-1 block w-full"
                          wire:model.lazy="member.lastname"
                          required autofocus autocomplete="lastname"/>
            @error('member.lastname')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="mt-3">
            <x-input-label for="birthday" :value="__('Birthday')"/>
            <x-input-date id="birthday" name="birthday" type="text" class="mt-1 block w-full"
                              wire:model.lazy="birthday"
                          autofocus autocomplete="birthday"/>
            @error('birthday')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="mt-3">
            <x-input-label for="phone" :value="__('Phone')"/>
            <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full"
                          wire:model.lazy="member.phone"
                          autofocus autocomplete="phone"/>
            @error('member.phone')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="mt-3">
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                          wire:model.lazy="member.email"
                          required autofocus autocomplete="email"/>
            @error('member.email')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="mt-3">
            <x-input-label for="street" :value="__('Street')"/>
            <x-text-input id="street" name="street" type="text" class="mt-1 block w-full"
                          wire:model.lazy="member.street"
                          required autofocus autocomplete="street"/>
            @error('member.street')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
        <div class="flex gap-2 mt-3">
            <div class="basis-1/3">
                <x-input-label for="zip" :value="__('Zip')"/>
                <x-text-input id="zip" name="zip" type="number" class="mt-1 block w-full"
                              wire:model.lazy="member.zip"
                              required autofocus autocomplete="zip"/>
                @error('member.zip')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
            <div class="basis-2/3">
                <x-input-label for="city" :value="__('City')"/>
                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full"
                              wire:model.lazy="member.city"
                              required autofocus autocomplete="city"/>
                @error('member.city')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
        </div>
    </div>
</section>
