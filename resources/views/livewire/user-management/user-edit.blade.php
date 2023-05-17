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
            <x-default-button
                x-data="{ clickCnt: 0, onClick() {
                if(this.clickCnt > 0) {
                    $wire.deleteUser();
                } else {
                    this.clickCnt++;
                    $el.innerHTML = 'Are you sure?';
                }
            }}"
                x-on:click="onClick()"
                class="btn-danger">{{ __('Delete user') }}</x-default-button>
        </div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5">
        <div class="p-4 sm:p-8 max-w-xl">
            <x-livewire.user-management.user-form/>
        </div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-4 sm:p-8">
            <x-livewire.user-management.user-permission/>
        </div>
    </div>
</div>
