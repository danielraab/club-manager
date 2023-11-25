<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Edit member") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 gap-2 items-center">
        <div class="flex justify-between">
            <div class="flex items-center gap-2">
                <x-default-button
                    x-data="{ clickCnt: 0, onClick() {
                        if(this.clickCnt > 0) {
                            $wire.deleteMember();
                        } else {
                            this.clickCnt++;
                            $el.innerHTML = 'Are you sure?';
                        }
                    }}"
                    x-on:click="onClick()" title="Delete this member"
                    class="btn-danger">{{ __('Delete member') }}</x-default-button>
                <x-default-button class="btn-secondary"
                                  wire:click="createUser">{{__("Create user")}}</x-default-button>
            </div>
            <x-default-button class="btn-primary" wire:click="saveMember"
                              title="Create new member">{{ __('Save') }}</x-default-button>

        </div>
        @if(session()->has("createUserMessage"))
            @php
                $textColor = match (session()->pull("createUserStatus")){
                    'success' => 'text-green-600',
                    'error' => 'text-red-600',
                    default => ''
                };
            @endphp
            <p class="text-gray-700 mt-3 {{$textColor}}"
               x-init="setTimeout(()=> {$el.remove()}, 7000);">{{session()->pull("createUserMessage")}}</p>
        @endif
    </div>


    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.members.member-content/>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.members.member-member-group-selection :memberForm="$memberForm"/>
        </div>
    </div>

</div>
