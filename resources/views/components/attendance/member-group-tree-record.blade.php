@php
/** @var \App\Models\Event $event */
    /** @var \App\Models\MemberGroup $memberGroup */
@endphp
    <!-- Accordion Wrapper -->
<div x-data="{show:{{$attributes->get('initialShow', 'false')}}}" class="transition mb-1">
    <!-- header -->
    <div x-on:click="show= !show" :class="show ? 'bg-indigo-100':''"
         class="cursor-pointer transition flex justify-between sm:justify-start space-x-4 gap-2 py-2 px-5 items-center hover:bg-indigo-200 rounded">
            <i class="fas " :class="show ? 'fa-minus':'fa-plus'"></i>
            <h2 class="text-xl">{{__($memberGroup->title)}}</h2>
    </div>
    <!-- Content -->
    <div x-show="show" class="px-5 pt-0 overflow-hidden" x-transition>
        <div class="space-y-1 divide-y divide-gray-500">
        @foreach($memberGroup->members()->get() as $member)
            <livewire:attendance.single-attendance :event="$event" :member="$member" wire:key="tree-att-{{$event->id.'-'.$member->id}}"/>
        @endforeach
        </div>

        @foreach($memberGroup->children()->get() as $childMemberGroup)
            @if($childMemberGroup->members()->get()->isNotEmpty())
                <x-attendance.member-group-tree-record :memberGroup="$childMemberGroup" :event="$event"/>
            @endif
        @endforeach
    </div>
</div>
