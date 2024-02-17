<x-slot name="headline">
    <div class="flex items-center gap-2">
        <a href="{{route("sponsoring.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Edit period") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex justify-between items-center">
        <x-default-button
            x-data="{ clickCnt: 0, onClick() {
                        if(this.clickCnt > 0) {
                            $wire.deletePeriod();
                        } else {
                            this.clickCnt++;
                            $el.innerHTML = 'Are you sure?';
                        }
                    }}"
            x-on:click="onClick()" title="Delete this period"
            class="btn-danger">{{ __('Delete period') }}</x-default-button>
        <x-button-link href="{{route('sponsoring.period.backer.overview', $periodForm->period->id)}}" class="btn-info" title="Show period backer overview.">
            {{__("Show backer overview")}}
        </x-button-link>
        <x-default-button class="btn-primary" wire:click="savePeriod"
                          title="Update period">{{ __('Save') }}</x-default-button>
    </div>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.sponsoring.period-content/>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.sponsoring.period-package-selection/>
        </div>
    </div>

</div>
