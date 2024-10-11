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

        <x-button-dropdown.dropdown>
            <x-slot name="mainButton">
                <x-button-dropdown.mainButton class="btn-success" wire:click="savePeriod"
                        title="Save current changes" iconClass="fa-solid fa-floppy-disk mr-2">{{ __('Save') }}
                </x-button-dropdown.mainButton>
            </x-slot>

            <x-button-dropdown.button class="btn-success" wire:click="saveNewsCopy"
                    title="Save copy of the news" iconClass="fa-solid fa-copy">{{ __('Save copy') }}</x-button-dropdown.button>
            <x-button-dropdown.link href="{{route('sponsoring.period.backer.overview', $periodForm->period->id)}}"
               class="btn-info"
               title="Show period backer overview">
                {{__("Show backer overview")}}
            </x-button-dropdown.link>

            <x-button-dropdown.button
                    wire:confirm.prompt="{{__('Are you sure you want to delete the whole period? All contracts will get lost.\nEnter \'DELETE\' if your are sure.|DELETE')}}"
                    wire:click="deletePeriod" title="Delete this period"
                    class="btn-danger"
                    iconClass="fa-solid fa-trash">{{ __('Delete period') }}</x-button-dropdown.button>
        </x-button-dropdown.dropdown>
    </div>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            @include('livewire.sponsoring.partials.period-content')
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            @include('livewire.sponsoring.partials.period-package-selection')
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
