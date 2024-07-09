<x-slot name="headline">
    <div class="flex items-center gap-2">
        <a href="{{route("sponsoring.period.backer.overview", $period->id)}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Assign members to backers") }}
    </div>
</x-slot>

<div x-init="$store.notificationMessages
            .addNotificationMessages(
            JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3 ">
        <x-accordion title="Quick add a backer" class="min-w-60 text-sm text-gray-700">
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
    </div>


    <div class="flex flex-col gap-4">
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
             @foreach(\App\Models\Member::getAllFiltered()->get() as $member)
                 @php
                 /** @var \App\Models\Member $member */
                 @endphp
                 <div>
                     {{$member->getFullName()}}
                 </div>
             @endforeach
        </div>
    </div>

</div>
