<x-accordion title="Quick add a backer" class="min-w-60 text-sm text-gray-700 border-none">
    <form wire:submit="addNewBacker" class="flex flex-wrap gap-3 text-xs my-2 align-end">
        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-input id="name" name="name" type="text" class="mt-1 block w-full"
                     wire:model="name"
                     required autofocus autocomplete="name"/>
            @error('name')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
        <div>
            <x-input-label for="country" :value="__('Country')" required/>
            <x-select id="country" name="country" class="mt-1 block w-full"
                      wire:model="country"
                      required autofocus autocomplete="country">
                @foreach(\App\Models\Country::array() as $code => $name)
                    <option value="{{$code}}">{{__($name)}}</option>
                @endforeach
            </x-select>
            @error('country')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div>
            <x-input-label for="zip" :value="__('ZIP')"/>
            <x-input id="zip" name="zip" type="number" class="mt-1 block w-full"
                     wire:model="zip"
                     autofocus autocomplete="zip"/>
            @error('zip')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
        <div>
            <x-input-label for="city" :value="__('City')"/>
            <x-input id="city" name="city" type="text" class="mt-1 block w-full"
                     wire:model="city"
                     autofocus autocomplete="city"/>
            @error('city')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
        <button type="submit" class="btn btn-create px-4"
                title="Edit this period">{{__('Add new Backer')}}</button>
    </form>
</x-accordion>
