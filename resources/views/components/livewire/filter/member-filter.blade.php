<div class="flex flex-wrap gap-2 justify-center text-sm"
    @if($this->useMemberGroupFilter === true)
        <div x-data="{open:false}" @click.outside="open = false" @close.stop="open = false">
            @if($this->filterMemberGroup)
                <button x-ref="memberGroupDropdown" class="btn btn-secondary py-0 bg-green-800 text-white"
                        title="A member group filter is selected"
                        type="button" @click="open=!open">
                    <i class="fa-solid fa-user-group text-xl mr-2"></i>
                    <i class="fa-solid fa-caret-down"></i>
                </button>
            @else
                <button x-ref="memberGroupDropdown" class="btn btn-secondary py-0"
                        title="Select a member group filter"
                        type="button" @click="open=!open">
                    <i class="fa-solid fa-user-group text-xl mr-2"></i>
                    <i class="fa-solid fa-caret-down"></i>
                </button>
            @endif
            <div x-show="open" x-cloak x-anchor.bottom-end="$refs.memberGroupDropdown" x-collapse
                 x-on:member-group-clicked="$wire.set('filterMemberGroup', $event.detail); open=false"
                 class="flex flex-col gap-2 bg-white rounded border overflow-hidden shadow-md z-50 p-2">
                @if($this->filterMemberGroup)
                    <button type="button" class="btn btn-secondary" wire:click="$set('filterMemberGroup', ''); open=false">
                        <i class="fa-solid fa-trash mr-2"></i>
                        {{__("clear member filter")}}
                    </button>
                @endif
                <ul>
                @foreach(\App\Models\MemberGroup::getTopLevelQuery()->get() as $memberGroup)
                    <x-members.member-group-dropdown-item :memberGroup="$memberGroup" :selectedMemberGroup="$this->filterMemberGroup"/>
                @endforeach
                </ul>
            </div>
        </div>
    @endif
    @if($this->filterShowPaused)
        <button class="btn btn-secondary py-0 bg-green-800 text-white"
                title="Paused are shown"
                type="button" wire:click="$set('filterShowPaused', false)">
            <i class="fa-regular fa-circle-pause text-xl"></i>
        </button>
    @else
        <button class="btn btn-secondary py-0"
                title="Paused are not shown"
                type="button" wire:click="$set('filterShowPaused', true)">
            <i class="fa-regular fa-circle-pause text-xl"></i>
        </button>
    @endif
    @if($this->filterShowBeforeEntrance)
        <button class="btn btn-secondary py-0 bg-green-800 text-white"
                title="Before entrance are shown"
                type="button" wire:click="$set('filterShowBeforeEntrance', false)">
            <i class="fa-solid fa-angles-left text-xl"></i>
        </button>
    @else
        <button class="btn btn-secondary py-0"
                title="Before entrance are not shown"
                type="button" wire:click="$set('filterShowBeforeEntrance', true)">
            <i class="fa-solid fa-angles-left text-xl"></i>
        </button>
    @endif
    @if($this->filterShowAfterRetired)
        <button class="btn btn-secondary py-0 bg-green-800 text-white"
                title="After retired are shown"
                type="button" wire:click="$set('filterShowAfterRetired', false)">
            <i class="fa-solid fa-angles-right text-xl"></i>
        </button>
    @else
        <button class="btn btn-secondary py-0"
                title="After retired are not shown"
                type="button" wire:click="$set('filterShowAfterRetired', true)">
            <i class="fa-solid fa-angles-right text-xl"></i>
        </button>
    @endif
</div>
