<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Edit info message") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex items-center justify-between">
            <x-default-button
                x-data="{ clickCnt: 0, onClick() {
                if(this.clickCnt > 0) {
                    $wire.deleteInfo();
                } else {
                    this.clickCnt++;
                    $el.innerHTML = 'Are you sure?';
                }
            }}"
                x-on:click="onClick()" title="Delete this info message"
                class="btn-danger">{{ __('Delete message') }}</x-default-button>
            <x-default-button class="btn-primary" wire:click="saveInfo"
                              title="Save current changes">{{ __('Save') }}</x-default-button>
        </div>
    </div>


    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.info-message.info-content />
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.info-message.info-settings :info="$info"/>
        </div>
    </div>

</div>
