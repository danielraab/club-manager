<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Update member group") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex items-center justify-between">
            <x-default-button
                x-data="{ clickCnt: 0, onClick() {
                if(this.clickCnt > 0) {
                    $wire.deleteMemberGroup();
                } else {
                    this.clickCnt++;
                    $el.innerHTML = 'Are you sure?';
                }
            }}"
                x-on:click="onClick()" title="Delete this member group"
                class="btn-danger">{{ __('Delete member group') }}</x-default-button>
            <x-default-button class="btn-primary" wire:click="saveMemberGroup"
                              title="Create new member group">{{ __('Save') }}</x-default-button>
        </div>
    </div>


    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">
        <x-livewire.members.member-group-content :memberGroup="$memberGroup"/>
        <x-livewire.members.member-group-member-selection />
    </div>

</div>
