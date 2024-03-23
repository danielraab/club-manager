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
        <x-button-dropdown>
            <x-slot name="mainButton">
                <button type="button" class="btn-success p-2 text-xs" wire:click="savePackage"
                        title="Update package"><i class="fa-solid fa-floppy-disk mr-2"></i>{{ __('Save') }}</button>
            </x-slot>
            <button type="button"
                    wire:confirm="{{__('Are you sure you want to delete this package?')}}"
                    wire:click="deletePackage" title="Delete this package"
                    class="btn-danger p-2 text-xs">
                <i class="fa-solid fa-trash mr-2"></i>{{ __('Delete package') }}</button>
        </x-button-dropdown>
    </div>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.sponsoring.package-content/>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.sponsoring.package-ad-option-selection/>
        </div>
    </div>

</div>
