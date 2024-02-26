<x-slot name="headline">
    <div class="flex items-center gap-2">
        <a href="{{route("sponsoring.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Add new period") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex justify-end gap-2 items-center">
        @if(session()->has("savedAndStayMessage"))
            <p class="text-gray-700"
            x-init="setTimeout(()=> {$el.remove()}, 5000);">{{session()->pull("savedAndStayMessage")}}</p>
        @endif
        <x-default-button class="bg-cyan-700 hover:bg-cyan-500 focus:bg-cyan-500 text-white"
                          wire:click="savePeriodAndStay"
                          title="Create new period and stay on this site">{{ __('Save and stay') }}</x-default-button>
        <x-default-button class="btn-primary" wire:click="savePeriod"
                          title="Create new period">{{ __('Save') }}</x-default-button>
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
