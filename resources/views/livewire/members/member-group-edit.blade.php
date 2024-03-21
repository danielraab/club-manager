<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Update member group") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex items-center justify-end">
        <x-button-dropdown>
            <x-slot name="mainButton">
                <button type="button" class="btn-success p-2 text-xs gap-2" wire:click="saveMemberGroup"
                        title="Create new member group"><i class="fa-solid fa-floppy-disk"></i> {{ __('Save') }}
                </button>
            </x-slot>
            <button type="button"
                    wire:confirm.prompt="{{__('Are you sure you want to delete the this member group?')}}"
                    wire:click="deleteMember" title="Delete this member group"
                    class="btn-danger inline-flex gap-2 text-xs p-2"><i
                    class="fa-solid fa-trash"></i> {{ __('Delete member group') }}</button>
        </x-button-dropdown>
    </div>


    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">
        <x-livewire.members.member-group-content :memberGroupForm="$memberGroupForm"/>
        <x-livewire.members.member-group-member-selection/>
    </div>

</div>
