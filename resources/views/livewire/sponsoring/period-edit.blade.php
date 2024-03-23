<x-slot name="headline">
    <div class="flex items-center gap-2">
        <a href="{{route("sponsoring.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Edit period") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3 p-5 flex justify-end items-center">

        <x-button-dropdown>
            <x-slot name="mainButton">
                <button type="button" class="btn-success p-2 text-xs" wire:click="savePeriod"
                        title="Save current changes"><i class="fa-solid fa-floppy-disk mr-2"></i>{{ __('Save') }}
                </button>
            </x-slot>

            <button type="button" class="btn-success inline-flex gap-2 p-2 text-xs" wire:click="saveNewsCopy"
                    title="Save copy of the news"><i class="fa-solid fa-copy"></i> {{ __('Save copy') }}</button>
            <a href="{{route('sponsoring.period.backer.overview', $periodForm->period->id)}}"
               class="btn-info inline-flex gap-2 p-2 text-xs"
               title="Show period backer overview">
                {{__("Show backer overview")}}
            </a>

            <button type="button"
                    wire:confirm.prompt="{{__('Are you sure you want to delete the whole period? All contracts will get lost.\nEnter \'DELETE\' if your are sure.|DELETE')}}"
                    wire:click="deletePeriod" title="Delete this period"
                    class="text-xs p-2 btn-danger inline-flex gap-2">
                <i class="fa-solid fa-trash"></i> {{ __('Delete period') }}</button>
        </x-button-dropdown>
    </div>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.sponsoring.period-content/>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.sponsoring.period-package-selection/>
        </div>


        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{__("Period files")}}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Manage files according to this period. e.g. forms, description, etc.") }}
                    </p>
                </header>

                <livewire:sponsoring.period-files :period="$periodForm->period"/>
            </section>
        </div>
    </div>

</div>
