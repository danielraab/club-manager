<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Event') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Enter basic information for the event.") }}
        </p>
    </header>

    <div class="mt-6">
        <div>
            <x-input-label for="title" :value="__('Title')"/>
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" wire:model.defer="event.title"
                          required autofocus autocomplete="title"/>
            @error('event.title')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="my-3">
            <x-input-label for="description" :value="__('Description')"/>
            <x-textarea id="description" name="description" class="mt-1 block w-full min-h-[100px]"
                        wire:model.defer="event.description" required autocomplete="description"/>
            @error('event.description')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div>
            <x-input-label for="location" :value="__('Location')"/>
            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" wire:model.defer="event.location"
                          list="locationHistory" required autofocus autocomplete="location"/>
            <datalist id="locationHistory">
                @foreach(\App\Models\Event::getLocationHistory() as $location)
                    <option value="{{$location}}"></option>
                @endforeach
            </datalist>
            @error('event.location')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div>
            <x-input-label for="dress_code" :value="__('Dress code')"/>
            <x-text-input id="dress_code" name="dress_code" type="text" class="mt-1 block w-full" wire:model.defer="event.dress_code"
                          list="dressCodeHistory" required autofocus autocomplete="dress_code"/>
            <datalist id="dressCodeHistory">
                @foreach(\App\Models\Event::getDressCodeHistory() as $dressCode)
                    <option value="{{$dressCode}}"></option>
                @endforeach
            </datalist>
            @error('event.dress_code')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div>
            <x-input-label for="link" :value="__('Link')"/>
            <x-text-input id="link" name="link" type="url" class="mt-1 block w-full" wire:model.defer="event.link"
                          required autofocus autocomplete="link"/>
            @error('event.link')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
    </div>
</section>
