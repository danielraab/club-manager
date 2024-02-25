<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Backer') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Enter basic information of the backer.") }}
        </p>
    </header>

    <div class="mt-6">

        <div class="mt-3">
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                          wire:model="backerForm.name"
                          required autofocus autocomplete="name"/>
            @error('backerForm.name')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="mt-3">
            <x-input-label for="contactPerson" :value="__('contact person')"/>
            <x-text-input id="contactPerson" name="contactPerson" type="text" class="mt-1 block w-full"
                          wire:model="backerForm.contact_person"
                          required autofocus autocomplete="contactPerson"/>
            @error('backerForm.contact_person')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="mt-3">
            <x-input-label for="phone" :value="__('Phone')"/>
            <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full"
                          wire:model="backerForm.phone"
                          autofocus autocomplete="phone"/>
            @error('backerForm.phone')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="mt-3">
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                          wire:model="backerForm.email"
                          required autofocus autocomplete="email"/>
            @error('backerForm.email')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="mt-3">
            <x-input-label for="street" :value="__('Street')"/>
            <x-text-input id="street" name="street" type="text" class="mt-1 block w-full"
                          wire:model="backerForm.street"
                          required autofocus autocomplete="street"/>
            @error('backerForm.street')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
        <div class="flex gap-2 mt-3">
            <div class="basis-1/3">
                <x-input-label for="zip" :value="__('ZIP')"/>
                <x-text-input id="zip" name="zip" type="number" class="mt-1 block w-full"
                              wire:model="backerForm.zip"
                              required autofocus autocomplete="zip"/>
                @error('backerForm.zip')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
            <div class="basis-2/3">
                <x-input-label for="city" :value="__('City')"/>
                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full"
                              wire:model.blur="backerForm.city"
                              required autofocus autocomplete="city"/>
                @error('backerForm.city')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
        </div>

    </div>
</section>
