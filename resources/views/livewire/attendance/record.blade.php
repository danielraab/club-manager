@php
/** @var $event \App\Models\Event */
/** @var $members \Illuminate\Database\Eloquent\Collection */
@endphp

<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Update event attendance") }}
    </div>
</x-slot>

<div>
    <x-livewire.loading/>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex flex-wrap gap-2 items-center justify-between" >
            <span
                class="text-gray-500">{{$event->start->setTimezone(config("app.displayed_timezone"))->isoFormat("ddd D. MMM YYYY HH:mm")}}</span>
            <span class="text-gray-700 text-xl">{{$event->title}}</span>
        </div>
    </div>


    <div class="flex justify-center gap-4 bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex items-center flex-wrap justify-center gap-5">
            <div class="flex items-center flex-wrap justify-center">
                <x-input-label for="displayType" :value="__('Display type:')"/>
                <select name="displayType" id="displayType" wire:model.lazy="displayType"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ml-3 py-1 text-sm"
                >
                    <option value="alphabetically">{{__("Alphabetically")}}</option>
                    <option value="memberGroups">{{__("Member Groups")}}</option>
                </select>
            </div>
            <x-input-checkbox id="active" name="active" wire:model.lazy="onlyActive"
                              class="rounded ext-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('active members only') }}
            </x-input-checkbox>
            <x-button-link class="btn-primary" href="{{route('event.attendance.show', $event->id)}}">Show Overview</x-button-link>
        </div>
    </div>
    <div class="flex justify-center gap-4 bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        @if($displayType ==="alphabetically")
            <div class="flex flex-col justify-center text-center divide-y">
                @foreach($members->get() as $member)
                    <livewire:attendance.attendance :event="$event" :member="$member" wire:key="{{$event.'-'.$member}}"/>
                @endforeach
            </div>
        @elseif($displayType === "memberGroups")
            <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">
                @foreach(\App\Models\MemberGroup::getTopLevelQuery()->get() as $memberGroup)
                    <div>{{$memberGroup->title}}</div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">
                Please select a display type
            </div>
        @endif
    </div>

</div>
