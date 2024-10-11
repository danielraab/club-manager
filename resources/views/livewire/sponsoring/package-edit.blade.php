<x-slot name="headline">
    <div class="flex items-center gap-2">
        <a href="{{route("sponsoring.package.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Edit package") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3 p-5 flex justify-end items-center">
        <x-button-dropdown.dropdown>
            <x-slot name="mainButton">
                <x-button-dropdown.mainButton class="btn-success p-2 text-xs" wire:click="savePackage"
                        title="Update package" iconClass="fa-solid fa-floppy-disk">{{ __('Save') }}</x-button-dropdown.mainButton>
            </x-slot>
            <x-button-dropdown.button
                    wire:confirm="{{__('Are you sure you want to delete this package?')}}"
                    wire:click="deletePackage" title="Delete this package"
                    class="btn-danger"
                    iconClass="fa-solid fa-trash">{{ __('Delete package') }}</x-button-dropdown.button>
        </x-button-dropdown.dropdown>
    </div>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            @include('livewire.sponsoring.partials.package-content')
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            @include('livewire.sponsoring.partials.package-ad-option-selection')
        </div>
    </div>
</div>
