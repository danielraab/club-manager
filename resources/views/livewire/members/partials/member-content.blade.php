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
            <x-input id="title_pre" name="title_pre" type="text" class="mt-1 block w-full"
                          wire:model="memberForm.title_pre"
                          required autofocus autocomplete="title_pre"/>
            @error('memberForm.title_pre')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
        <div>
            <x-input-label for="title_post" :value="__('Postfixed Title')"/>
            <x-input id="title_post" name="title_post" type="text" class="mt-1 block w-full"
                          wire:model="memberForm.title_post"
                          required autofocus autocomplete="title_post"/>
            @error('memberForm.title_post')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
        </div>
        <div>
            <x-input-label for="firstname" :value="__('Firstname')"/>
            <x-input id="firstname" name="firstname" type="text" class="mt-1 block w-full"
                          wire:model="memberForm.firstname"
                          required autofocus autocomplete="firstname"/>
            @error('memberForm.firstname')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
        <div class="mt-3">
            <x-input-label for="lastname" :value="__('Lastname')"/>
            <x-input id="lastname" name="lastname" type="text" class="mt-1 block w-full"
                          wire:model="memberForm.lastname"
                          required autofocus autocomplete="lastname"/>
            @error('memberForm.lastname')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="mt-3">
            <x-input-label for="birthday" :value="__('Birthday')"/>
            <x-input type="date" id="birthday" name="birthday" class="mt-1 block w-full"
                              wire:model="memberForm.birthday"
                          autofocus autocomplete="birthday"/>
            @error('memberForm.birthday')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="mt-3">
            <x-input-label for="phone" :value="__('Phone')"/>
            <x-input id="phone" name="phone" type="tel" class="mt-1 block w-full"
                          wire:model="memberForm.phone"
                          autofocus autocomplete="phone"/>
            @error('memberForm.phone')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="mt-3">
            <x-input-label for="email" :value="__('Email')"/>
            <x-input id="email" name="email" type="email" class="mt-1 block w-full"
                          wire:model="memberForm.email"
                          required autofocus autocomplete="email"/>
            @error('memberForm.email')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="mt-3">
            <x-input-label for="street" :value="__('Street')"/>
            <x-input id="street" name="street" type="text" class="mt-1 block w-full"
                          wire:model="memberForm.street"
                          required autofocus autocomplete="street"/>
            @error('memberForm.street')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
        <div class="flex gap-2 mt-3">
            <div class="basis-1/3">
                <x-input-label for="zip" :value="__('ZIP')"/>
                <x-input id="zip" name="zip" type="number" class="mt-1 block w-full"
                              wire:model="memberForm.zip"
                              required autofocus autocomplete="zip"/>
                @error('memberForm.zip')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
            <div class="basis-2/3">
                <x-input-label for="city" :value="__('City')"/>
                <x-input id="city" name="city" type="text" class="mt-1 block w-full"
                              wire:model="memberForm.city"
                              required autofocus autocomplete="city"/>
                @error('memberForm.city')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
        </div>
    </div>
</section>
