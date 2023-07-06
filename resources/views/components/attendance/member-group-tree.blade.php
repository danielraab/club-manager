@php
/** @var \App\Models\MemberGroup $memberGroup */
@endphp
<!-- Accordion Wrapper -->
<div x-data="{show:false}" class="transition hover:bg-indigo-50" :class="show ? 'bg-indigo-50':''">
    <!-- header -->
    <div x-on:click="show= !show"
        class="cursor-pointer transition flex justify-between sm:justify-start space-x-4 px-5 items-center">
        <div class="flex items-center gap-2">
            <i class="fas " :class="show ? 'fa-minus':'fa-plus'"></i>
            <h3>{{__($memberGroup->title)}}</h3>
        </div>
        <div class="flex">
            <div class="text-white text-xs bg-green-700 rounded-full w-6 h-6 flex justify-center items-center">1</div>
            <div class="text-white text-xs bg-orange-700 rounded-full w-6 h-6 flex justify-center items-center">2</div>
            <div class="text-white text-xs bg-red-700 rounded-full w-6 h-6 flex justify-center items-center">3</div>
        </div>
    </div>
    <!-- Content -->
    <div x-show="show" class="ml-5 px-5 pt-0 overflow-hidden" x-transition.duration.500ms>
        @foreach($memberGroup->members()->get() as $member)
            <div class="flex items-center gap-2">
                <span>{{__($member->getFullName())}}</span>
            </div>
        @endforeach

        @foreach($memberGroup->children()->get() as $childMemberGroup)
            @if($childMemberGroup->members()->get()->isNotEmpty())
            <x-attendance.member-group-tree :memberGroup="$childMemberGroup" :event="$event"/>
            @endif
        @endforeach
    </div>
</div>
