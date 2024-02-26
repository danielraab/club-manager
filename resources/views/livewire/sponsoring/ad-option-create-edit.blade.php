@php
/** @var $editMode bool */
@endphp
<x-slot name="headline">
    <div class="flex items-center gap-2">
        <a href="{{route("sponsoring.ad-option.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ $editMode ? __("Edit ad option") : __("Add new ad option") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex gap-2 items-center
    {{$editMode ? "justify-between" : "justify-end"}}">
        @if($editMode)
            <x-default-button
                x-data="{ clickCnt: 0, onClick() {
                    if(this.clickCnt > 0) {
                        $wire.deleteAdOption();
                    } else {
                        this.clickCnt++;
                        $el.innerHTML = 'Are you sure?';
                    }
                }}"
                x-on:click="onClick()" title="Delete this ad option"
                class="btn-danger">{{ __('Delete ad option') }}</x-default-button>
            <x-default-button class="btn-primary" wire:click="saveAdOption"
                              title="Save changes of ad option">{{ __('Save') }}</x-default-button>
        @else
            @if(session()->has("savedAndStayMessage"))
                <p class="text-gray-700"
                   x-init="setTimeout(()=> {$el.remove()}, 5000);">{{session()->pull("savedAndStayMessage")}}</p>
            @endif
            <x-default-button class="bg-cyan-700 hover:bg-cyan-500 focus:bg-cyan-500 text-white"
                          wire:click="saveAdOptionAndStay"
                          title="Create new ad option and stay on this site">{{ __('Save and stay') }}</x-default-button>
            <x-default-button class="btn-primary" wire:click="saveAdOption"
                          title="Create new ad option">{{ __('Save') }}</x-default-button>
        @endif
    </div>

    <div class="flex justify-center">
        <div class="bg-white shadow-sm sm:rounded-lg p-4 w-full max-w-screen-sm">
            <div>
                <x-input-checkbox id="enabled" name="enabled" wire:model="adOptionForm.enabled"
                                  class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    {{ __('Is enabled') }} <i class="fa-solid fa-circle-info text-gray-500 ml-2"
                                              title="{{__("The adOption is enabled.")}}"></i>
                </x-input-checkbox>
            </div>

            <div class="mt-3">
                <x-input-label for="title" :value="__('Title')"/>
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                              wire:model="adOptionForm.title"
                              required autofocus autocomplete="title"/>
                @error('adOptionForm.title')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>

            <div class="mt-3">
                <x-input-label for="description" :value="__('Description')"/>
                <x-textarea id="description" name="description" type="text" class="mt-1 block w-full"
                            wire:model="adOptionForm.description"
                            autofocus autocomplete="description"/>
                @error('adOptionForm.description')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>

            <div class="mt-3">
                <x-input-label for="price" :value="__('Price')"/>
                <x-input-currency id="price" name="price" class="mt-1 block w-full"
                                  wire:model="adOptionForm.price"
                                  autofocus autocomplete="price" />
                @error('adOptionForm.price')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
        </div>
    </div>

</div>
