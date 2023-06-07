<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Create new user") }}
    </div>
</x-slot>

<div class="space-y-5">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5 flex flex-row-reverse">
        <x-default-button class="btn-primary" wire:click="saveUser"
                          title="Create new user">{{ __('Save') }}</x-default-button>
    </div>
    <div class="md:flex justify-center">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 sm:p-8 max-w-xl">
                <x-livewire.user-management.user-form/>
            </div>
        </div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-4 sm:p-8">
            <x-livewire.user-management.user-permission/>
        </div>
    </div>
</div>
