<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Create new info message") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex flex-row-reverse">
        <x-default-button class="btn-primary" wire:click="saveInfo"
                          title="Create new info message">{{ __('Save') }}</x-default-button>
    </div>


    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.info-message.info-content/>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.info-message.info-settings/>
        </div>
    </div>

</div>
