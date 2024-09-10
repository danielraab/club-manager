<div x-data="{
    open:false
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
         class="z-10 mt-2 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">

        @if($this->canFilterShowDisabled())
            <div class="px-4 py-1">
                <x-input-checkbox id="filter_disabled" name="filter_disabled"
                                  wire:model.live="showDisabled">
                    {{ __('show disabled') }}
                </x-input-checkbox>
            </div>
        @endif
        @if($this->canFilterMemberGroup())
            <div class="px-4 py-1">
                <x-input-label for="member_group_id" :value="__('Member group')"/>
                <x-select id="member_group_id" name="member_group_id"
                          wire:model.live="memberGroupId"
                          class="block mt-1 w-full">
                    <option value="all">All</option>
                    <option value="">-</option>
                    @foreach(\App\Models\MemberGroup::getTopLevelQuery()->get() as $memberGroup)
                        <x-members.member-group-select-option :memberGroup="$memberGroup"/>
                    @endforeach
                </x-select>
            </div>
        @endif
        <x-accordion label="Date filter" class="min-w-60 text-sm text-gray-700">

            <div x-on:switched="$wire.set('isStartNow', $event.detail.enabled)">
                <label class="flex items-center gap-2">
                    <x-input-switch :enabled="$this->isStartNow"/>
                    <span>{{__("Hide past")}}</span>
                </label>
                @if(!$this->isStartNow)
                    <label title="{{__('Filter start date')}}"
                           class="flex border border-gray-700 divide-x focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-1 w-fit overflow-hidden">
                        <div class="px-2 flex items-center {{ $this->start ? 'bg-green-700' : 'bg-gray-500' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                      d="M2 14h2v3h5v-3l4 4l-4 4v-3H4v3H2zm17 5V8H5v4H3V5c0-1.11.89-2 2-2h1V.998h2V3h8V.998h2V3h1a2 2 0 0 1 2 2v14c0 1.1-.9 2-2 2h-6.17l2-2z"/>
                            </svg>
                        </div>
                        <input type="date" wire:model.live="start" class="text-xs border-none" name="start">
                    </label>
                @endif
            </div>
            <div class="">
                <label title="{{__('Filter end date')}}"
                       class="flex border border-gray-700 divide-x focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm m-1 w-fit overflow-hidden">
                    <div class="px-2 flex items-center {{ $this->end ? 'bg-red-700' : 'bg-gray-500' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                  d="M22 14v8h-2v-4l-4 4v-3h-5v-2h5v-3l4 4v-4zM5 19h4v2H5c-1.1 0-2-.9-2-2V5a2 2 0 0 1 2-2h1V.998h2V3h8V.998h2V3h1c1.11 0 2 .89 2 2v7h-2V8H5z"/>
                        </svg>
                    </div>
                    <input type="date" wire:model.live="end" class="text-xs border-none" name="end">
                </label>
            </div>
        </x-accordion>
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
