<x-slot name="headline">
    <div class="flex items-center gap-2">
        <a href="{{route("sponsoring.package.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Edit package") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex justify-between items-center">
        <x-default-button
            x-data="{ clickCnt: 0, onClick() {
                        if(this.clickCnt > 0) {
                            $wire.deletePackage();
                        } else {
                            this.clickCnt++;
                            $el.innerHTML = 'Are you sure?';
                        }
                    }}"
            x-on:click="onClick()" title="Delete this package"
            class="btn-danger">{{ __('Delete package') }}</x-default-button>
        <x-default-button class="btn-primary" wire:click="savePackage"
                          title="Update package">{{ __('Save') }}</x-default-button>
    </div>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.sponsoring.package-content/>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            todo
        </div>
    </div>

</div>
