<x-slot name="headline">
    <div class="flex items-center gap-2">
        <a href="{{route("sponsoring.backer.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Edit backer") }}
    </div>
</x-slot>

<div>
    <x-livewire.loading />
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex justify-between items-center">
        <x-default-button
            x-data="{ clickCnt: 0, onClick() {
                        if(this.clickCnt > 0) {
                            $wire.deleteBacker();
                        } else {
                            this.clickCnt++;
                            $el.innerHTML = 'Are you sure?';
                        }
                    }}"
            x-on:click="onClick()" title="Delete this backer"
            class="btn-danger">{{ __('Delete backer') }}</x-default-button>
        <x-default-button class="btn-primary" wire:click="saveBacker"
                          title="Update backer">{{ __('Save') }}</x-default-button>
    </div>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.sponsoring.backer-content/>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.sponsoring.backer-files/>
        </div>
    </div>

</div>
