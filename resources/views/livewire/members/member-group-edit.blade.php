<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Update member group") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex items-center justify-end">
        <x-button-dropdown.dropdown>
            <x-slot name="mainButton">
                <x-button-dropdown.mainButton class="btn-success" wire:click="saveMemberGroup"
                        title="Create new member group" iconClass="fa-solid fa-floppy-disk">
                    {{ __('Save') }}
                </x-button-dropdown.mainButton>
            </x-slot>
            <x-button-dropdown.button
                    wire:confirm.prompt="{{__('Are you sure you want to delete the this member group?')}}"
                    wire:click="deleteMember" title="Delete this member group"
                    class="btn-danger"
                    iconClass="fa-solid fa-trash"
            >{{ __('Delete member group') }}</x-button-dropdown.button>
        </x-button-dropdown.dropdown>
    </div>


    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">
        <x-livewire.members.member-group-content :memberGroupForm="$memberGroupForm"/>
        <x-livewire.members.member-group-member-selection/>
    </div>

</div>
