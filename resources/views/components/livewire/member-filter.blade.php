@props(["useMemberGroupFilter" => false])
<div class="flex flex-wrap gap-5 justify-center text-sm"
    x-data="{
    @if($useMemberGroupFilter === true)
        filterMemberGroup: $persist(@entangle('filterMemberGroup').live).using(sessionStorage),
    @endif
        showBeforeEntrance: $persist(@entangle('filterShowBeforeEntrance').live),
        showAfterRetired: $persist(@entangle('filterShowAfterRetired').live),
        showPaused: $persist(@entangle('filterShowPaused').live)
    }">
    @if($useMemberGroupFilter === true)
    <div class="flex items-center flex-wrap justify-center">
        <x-input-label for="filterMemberGroup" :value="__('Filter member group:')"/>
        <select name="filterMemberGroup" id="filterMemberGroup" wire:model.lazy="filterMemberGroup"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ml-3 py-1 text-sm"
        >
            <option></option>
            @foreach(\App\Models\MemberGroup::getTopLevelQuery()->get() as $memberGroup)
                <x-members.member-group-select-option :memberGroup="$memberGroup"/>
            @endforeach
        </select>
    </div>
    @endif

    <div x-data="{
            open:false,
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
             class="absolute left-1/2 transform -translate-x-1/2 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
            <div class="py-1">
                <div class="px-4 py-1">
                    <x-input-checkbox id="filter_before_entrance" name="filter_before_entrance"
                                      wire:model.live="filterShowBeforeEntrance">
                        {{ __('show before entrance') }}
                    </x-input-checkbox>
                </div>
                <div class="px-4 py-1">
                    <x-input-checkbox id="filter_after_entrance" name="filter_after_entrance"
                                      wire:model.live="filterShowAfterRetired">
                        {{ __('show after retired') }}
                    </x-input-checkbox>
                </div>
                <div class="px-4 py-1">
                    <x-input-checkbox id="filter_not_paused" name="filter_not_paused"
                                      wire:model.live="filterShowPaused">
                        {{ __('show paused') }}
                    </x-input-checkbox>
                </div>
            </div>
        </div>
    </div>
</div>
