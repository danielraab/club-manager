
<div x-data="{
    open:false,
    showPast: $persist(@entangle('showPast')),
    showDisabled: $persist(@entangle('showDisabled')),
    showLoggedInOnly: $persist(@entangle('showLoggedInOnly')),
}" class="relative inline-block text-left" @click.outside="open = false">
    <div>
        <button type="button"
                class="inline-flex w-full justify-center items-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                @click.stop="open = !open">
            <i class="fa-solid fa-filter"></i> Filter
            <i class="fa-solid fa-chevron-down text-gray-400 transition"
               :class="open ? 'rotate-180' : ''"></i>
        </button>
    </div>

    <div x-cloak x-show="open"
         class="absolute left-1/2 transform -translate-x-1/2 z-10 mt-2 w-56 origin-top-right divide-y divide-gray-500 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
        <div class="py-1">
            @if($this->canFilterShowPast())
            <div class="px-4 py-1">
                <x-input-checkbox id="filter_past" name="filter_past"
                                  wire:model="showPast">
                    {{ __('show past') }}
                </x-input-checkbox>
            </div>
            @endif
            @if($this->canFilterShowDisabled())
            <div class="px-4 py-1">
                <x-input-checkbox id="filter_disabled" name="filter_disabled"
                                  wire:model="showDisabled">
                    {{ __('show disabled') }}
                </x-input-checkbox>
            </div>
            @endif
            @if($this->canFilterShowLoggedInOnly())
            <div class="px-4 py-1">
                <x-input-checkbox id="filter_logged_in_only" name="filter_logged_in_only"
                                  wire:model="showLoggedInOnly">
                    {{ __('show logged in only events') }}
                </x-input-checkbox>
            </div>
            @endif
        </div>
        <div class="py-1 px-3">
            <x-default-button class="btn-secondary px-3" wire:click="$toggle('sortAsc')">
                @if($this->sortAsc)
                    <i class="fa-solid fa-arrow-down"></i>
                @else
                    <i class="fa-solid fa-arrow-up"></i>
                @endif
                <span class="pl-2">{{$this->sortAsc ? __("sorted ascending") : __("sorted descending")}}</span>
            </x-default-button>
        </div>
    </div>
</div>
