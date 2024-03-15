@php
    /** @var $event \App\Models\Event */
    /** @var $members \Illuminate\Database\Eloquent\Collection */

    $memberFilter = $this->getMemberFilter();
@endphp

<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Update event attendance") }}
    </div>
</x-slot>

<div x-data="{displayMemberGroup:$persist(true)}">
    <x-livewire.loading/>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex flex-wrap gap-2 items-center justify-between">
            <span
                class="text-gray-500">{{$event->getFormattedStart()}}</span>
            <span class="text-gray-700 text-xl">{{$event->title}}</span>
        </div>
    </div>


    <div class="flex justify-center gap-4 bg-white shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex items-center flex-wrap justify-center gap-5">
            <a class="btn-primary"
                           href="{{route('event.attendance.show', $event->id)}}">{{__("Show Overview")}}</a>
            <div class="flex items-center flex-wrap justify-center">
                <button type="button" x-on:click="displayMemberGroup=false"
                        class="py-2 px-4 rounded-l-lg"
                        :class="{
                            'hover:bg-sky-500 bg-gray-300': displayMemberGroup,
                            'bg-sky-600': !displayMemberGroup
                            }">
                    {{__("List")}}</button>
                <button type="button" x-on:click="displayMemberGroup=true"
                        class="py-2 px-4 rounded-r-lg"
                        :class="{
                            'hover:bg-sky-500 bg-gray-300': !displayMemberGroup,
                            'bg-sky-600': displayMemberGroup
                            }">
                    {{__("Groups")}}</button>
            </div>
            <x-livewire.member-filter/>
        </div>
    </div>
    <div class="flex justify-center gap-4 bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div x-show="displayMemberGroup" class="flex flex-col lg:grid lg:grid-cols-2 gap-4">
            @foreach(\App\Models\MemberGroup::getTopLevelQuery()->get() as $memberGroup)
                <x-attendance.member-group-tree-record :memberGroup="$memberGroup" :event="$event"
                                                       initialShow="true" :memberFilter="$memberFilter"/>
            @endforeach
        </div>
        <div x-show="!displayMemberGroup" class="flex flex-col justify-center text-center divide-y divide-gray-500">
            @foreach($members->get() as $member)
                <livewire:attendance.single-attendance :event="$event" :member="$member"
                                                       wire:key="att-{{$event->id.'-'.$member->id}}"/>
            @endforeach
        </div>
    </div>

</div>
