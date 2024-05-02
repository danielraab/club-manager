@php
    /** @var \App\Calculation\AttendanceStatistic $attendanceStatistic */
    /** @var \App\Models\Event $event */
    /** @var \App\Models\MemberGroup $memberGroup */
    /** @var \App\Models\Filter\MemberFilter $memberFilter */
@endphp
        <!-- Accordion Wrapper -->
<div x-data="{show:{{$attributes->get('initialShow', 'false')}}}" class="transition mb-1">
    <!-- header -->
    <div x-on:click="show= !show" :class="show ? 'bg-indigo-100':''"
         class="cursor-pointer transition flex justify-between sm:justify-start space-x-4 px-5 items-center hover:bg-indigo-200 rounded">
        <div class="flex items-center gap-2 py-2">
            <i class="fas " :class="show ? 'fa-minus':'fa-plus'"></i>
            <h3>{{__($memberGroup->title)}}</h3>
        </div>
        @if($attendanceStatistic->getMemberGroupStat($memberGroup->id))
            <div class="flex gap-1">
                <div class="text-white text-xs bg-green-700 rounded-full w-6 h-6 flex justify-center items-center">
                    {{count($attendanceStatistic->getMemberGroupStat($memberGroup->id)->in)}}
                </div>
                <div class="text-white text-xs bg-yellow-600 rounded-full w-6 h-6 flex justify-center items-center">
                    {{count($attendanceStatistic->getMemberGroupStat($memberGroup->id)->unsure)}}
                </div>
                <div class="text-white text-xs bg-red-700 rounded-full w-6 h-6 flex justify-center items-center">
                    {{count($attendanceStatistic->getMemberGroupStat($memberGroup->id)->out)}}
                </div>
                <div class="text-white text-xs bg-green-700 w-6 h-6 flex justify-center items-center">
                    {{count($attendanceStatistic->getMemberGroupStat($memberGroup->id)->attended)}}
                </div>
            </div>
        @endif
    </div>
    <!-- Content -->
    <div x-show="show" class="px-5 pt-0 overflow-hidden space-y-1" x-transition>
        @foreach($memberGroup->members()->orderBy('lastname')->orderBy('firstname')->get() as $member)
            @php
                /** @var \App\Models\Member $member */
                    $currentAttendance = $member->attendances()->where('event_id', $event->id)->first();
                    if($currentAttendance === null &&
                                !($this->showUnattended && $member->matchFilter($defaultMemberFilter))) continue;
                    $cssClasses = $currentAttendance?->attended ? " bg-green-300" : '';
            @endphp
            <div class="flex gap-2 items-center px-2">
                <div class="h-2 w-2 rounded-full {{match($currentAttendance?->poll_status){
                        "in" => 'bg-green-700',
                        "unsure" => 'bg-yellow-600',
                        "out" => 'bg-red-700',
                        default => ''} }}"></div>
                <span class="rounded px-2 {{$cssClasses}}">{{__($member->getFullName())}}</span>
            </div>
        @endforeach

        @foreach($memberGroup->children()->get() as $childMemberGroup)
            @if($childMemberGroup->members()->get()->isNotEmpty() ||
                $childMemberGroup->children()->get()->isNotEmpty())
                <x-attendance.member-group-tree-display :memberGroup="$childMemberGroup" :event="$event"
                                                        :defaultMemberFilter="$defaultMemberFilter"
                                                        :attendanceStatistic="$attendanceStatistic"/>
            @endif
        @endforeach
    </div>
</div>
