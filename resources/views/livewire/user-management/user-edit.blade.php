<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __('Edit user') }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex items-center justify-between">
            <div class="flex">
                <x-default-button class="btn-primary" wire:click="saveUser">{{ __('Save') }}</x-default-button>
            </div>
            <x-default-button class="btn-danger" wire:click="deleteUser">{{ __('Delete user') }}</x-default-button>
        </div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-4 sm:p-8 max-w-xl">
            <x-livewire.user-management.user-form/>
        </div>
    </div>
</div>
