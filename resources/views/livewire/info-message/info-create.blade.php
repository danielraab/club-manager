<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Create new info message") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex flex-row-reverse">
        <x-default-button class="btn-primary" wire:click="saveInfo" title="Create new info message">{{ __('Save') }}</x-default-button>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5">
        <div class="p-4 sm:p-8 max-w-xl">
            <x-livewire.info-message.info-content/>
        </div>
    </div>
</div>
