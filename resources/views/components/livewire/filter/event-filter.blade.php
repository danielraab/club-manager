<div x-data="{
    open:false,
    start: $persist(@entangle('start').live).using(cookieStorage),
    end: $persist(@entangle('end').live).using(cookieStorage),
    showDisabled: $persist(@entangle('showDisabled').live),
    showLoggedInOnly: $persist(@entangle('showLoggedInOnly').live),
    sortAsc: $persist(@entangle('sortAsc').live),
}" class="relative text-left" @click.outside="open = false">


    <div>
        <button type="button" x-ref="filterButton"
                class="inline-flex w-full justify-center items-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                @click.stop="open = !open">
            <i class="fa-solid fa-filter"></i> Filter
            <i class="fa-solid fa-chevron-down text-gray-400 transition"
               :class="open ? 'rotate-180' : ''"></i>
        </button>
    </div>

    <div x-cloak x-show="open" x-anchor="$refs.filterButton"
         class="z-10 mt-2 divide-y divide-gray-500 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">

        @if($this->canFilterShowDisabled())
            <div class="px-4 py-1">
                <x-input-checkbox id="filter_disabled" name="filter_disabled"
                                  wire:model.live="showDisabled">
                    {{ __('show disabled') }}
                </x-input-checkbox>
            </div>
        @endif
        @if($this->canFilterShowLoggedInOnly())
            <div class="px-4 py-1">
                <x-input-checkbox id="filter_logged_in_only" name="filter_logged_in_only"
                                  wire:model.live="showLoggedInOnly">
                    {{ __('show logged in only events') }}
                </x-input-checkbox>
            </div>
        @endif
        <div class="pl-2">
            <label title="{{__('Filter start date')}}"
                class="flex border border-gray-700 divide-x focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-1 w-fit overflow-hidden">
                <div class="px-2 flex items-center"
                     :class="{ 'bg-green-700': start, 'bg-gray-500': !start }">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                        <path fill="currentColor"
                              d="M2 14h2v3h5v-3l4 4l-4 4v-3H4v3H2zm17 5V8H5v4H3V5c0-1.11.89-2 2-2h1V.998h2V3h8V.998h2V3h1a2 2 0 0 1 2 2v14c0 1.1-.9 2-2 2h-6.17l2-2z"/>
                    </svg>
                </div>
                <input type="date" wire:model.live="start" class="text-xs border-none" name="start">
            </label>
        </div>
        <div class="pl-2">
            <label title="{{__('Filter end date')}}"
                class="flex border border-gray-700 divide-x focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-1 w-fit overflow-hidden">
                <div class="px-2 flex items-center"
                     :class="{ 'bg-red-700': end, 'bg-gray-500': !end }">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                        <path fill="currentColor"
                              d="M22 14v8h-2v-4l-4 4v-3h-5v-2h5v-3l4 4v-4zM5 19h4v2H5c-1.1 0-2-.9-2-2V5a2 2 0 0 1 2-2h1V.998h2V3h8V.998h2V3h1c1.11 0 2 .89 2 2v7h-2V8H5z"/>
                    </svg>
                </div>
                <input type="date" wire:model.live="end" class="text-xs border-none" name="end">
            </label>
        </div>
        <div class="py-1 px-3">
            <button type="button" class="btn btn-secondary px-3" wire:click="$toggle('sortAsc')">
                @if($this->sortAsc)
                    <i class="fa-solid fa-arrow-down"></i>
                @else
                    <i class="fa-solid fa-arrow-up"></i>
                @endif
                <span class="pl-2">{{$this->sortAsc ? __("sorted ascending") : __("sorted descending")}}</span>
            </button>
        </div>
    </div>
</div>
