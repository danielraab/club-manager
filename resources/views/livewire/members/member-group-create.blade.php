<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Create new member group") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex items-center justify-end">
            <button type="button" class="btn btn-primary" wire:click="saveMemberGroup"
                    title="Create new member group">{{ __('Save') }}</button>
        </div>
    </div>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">
        <x-livewire.members.member-group-content :memberGroupForm="$memberGroupForm"/>
        <x-livewire.members.member-group-member-selection/>
    </div>

</div>
