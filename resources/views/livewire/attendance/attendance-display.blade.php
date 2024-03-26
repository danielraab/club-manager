@php
    /** @var \App\Calculation\AttendanceStatistic $statistic */
    /** @var \App\Models\Event $event */
    $hasAttendanceEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_EDIT_PERMISSION) ?? false;
    $hasEventEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Event::EVENT_EDIT_PERMISSION) ?? false;
@endphp

<x-slot name="headline">
    <div class="flex flex-wrap justify-between items-center gap-3">
        <span>{{ __('Attendance overview') }}</span>
    </div>
</x-slot>
<x-slot name="headerBtn">
    <div x-data="{open:false}" @click.outside="open = false" @close.stop="open = false">
        <div class="btn btn-primary items-center gap-2" x-ref="openButton" x-on:click="open = !open">
            <i class="fa-solid fa-vector-square"></i>
            <span class="max-sm:hidden">{{ __('Links') }}</span>
            <i class="fa-solid fa-caret-down"></i>
        </div>
        <div x-show="open" x-cloak x-anchor.bottom-end="$refs.openButton" x-collapse
             class="flex flex-col bg-white rounded border overflow-hidden shadow-md z-50">
            @if ($hasAttendanceEditPermission)
                <a class="btn-info p-2 text-xs"
                   href="{{ route('event.attendance.edit', $event->id) }}">
                    <i class="fa-solid fa-pen-to-square mr-2"></i>{{ __('Edit Attendance') }}
                </a>
            @endif
            @if ($hasEventEditPermission)
                <a class="btn-primary p-2 text-xs"
                   href="{{ route('event.edit', $event->id) }}">
                    <i class="fa-solid fa-pen-to-square mr-2"></i>{{ __('Edit event') }}
                </a>
            @endif
        </div>
    </div>
</x-slot>

<div x-data="{showGroup:true}">
    <x-livewire.loading/>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex flex-wrap gap-2 items-center justify-between">
            <span
                class="text-gray-500">{{$event->getFormattedStart()}}</span>
            <span class="text-gray-700 text-xl">{{$event->title}}</span>
        </div>
    </div>

    <div class="flex flex-wrap gap-3 justify-center mb-3">
        <div class="flex bg-white shadow rounded-lg p-5 items-center">
            <div class="text-white bg-green-700 rounded-full w-10 h-10 flex justify-center items-center">
                <i class="fa-solid fa-check "></i>
            </div>
            <div class="grow px-5">{{__("promised")}}</div>
            <div class="text-green-900 font-bold text-xl">{{$statistic->cntIn}}</div>
        </div>
        <div class="flex bg-white shadow rounded-lg p-5 items-center">
            <div class="text-white bg-yellow-600 rounded-full w-10 h-10 flex justify-center items-center">
                <i class="fa-solid fa-question "></i>
            </div>
            <div class="grow px-5">{{__("unsure")}}</div>
            <div class="text-orange-900 font-bold text-xl">{{$statistic->cntUnsure}}</div>
        </div>
        <div class="flex bg-white shadow rounded-lg p-5 items-center">
            <div class="text-white bg-red-700 rounded-full w-10 h-10 flex justify-center items-center">
                <i class="fa-solid fa-xmark "></i>
            </div>
            <div class="grow px-5">{{__("cancelled")}}</div>
            <div class="text-red-900 font-bold text-xl">{{$statistic->cntOut}}</div>
        </div>

        @if($statistic->cntAttended > 0)
            <div class="flex bg-green-700 shadow rounded-lg p-5 items-center text-white">
                <i class="fa-solid fa-check fa-2xl"></i>
                <div class="grow px-5">{{__("attended")}}</div>
                <div class="font-bold text-xl">{{$statistic->cntAttended}}</div>
            </div>
        @endif
    </div>


    <div class="flex justify-center gap-4 bg-white shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex items-center flex-wrap justify-center gap-5">
            <template x-if="showGroup">
                <div class="flex items-center flex-wrap justify-center">
                    <div class="py-2 px-4 rounded-l-lg bg-sky-600">
                        {{__("Groups")}}</div>
                    <button type="button" @click="showGroup = false"
                            class="py-2 px-4 rounded-r-lg hover:bg-sky-500 bg-gray-300">
                        {{__("List")}}</button>
                </div>
            </template>
            <template x-if="!showGroup">
                <div class="flex items-center flex-wrap justify-center">
                    <button type="button" @click="showGroup = true"
                            class="py-2 px-4 rounded-l-lg hover:bg-sky-500 bg-gray-300">
                        {{__("Groups")}}</button>
                    <div class="py-2 px-4 rounded-r-lg bg-sky-600">
                        {{__("List")}}</div>
                </div>
            </template>
        </div>
    </div>

    <div class="flex bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 justify-center">
        <div>
            <template x-if="showGroup">
                <div>

                    @foreach(\App\Models\MemberGroup::getTopLevelQuery()->get() as $memberGroup)
                        <x-attendance.member-group-tree-display :memberGroup="$memberGroup" :event="$event"
                                                                initialShow="true"
                                                                :attendanceStatistic="$statistic"/>
                    @endforeach
                </div>
            </template>
            <template x-if="!showGroup">
                <div>
                    @forelse($members = \App\Models\Member::query()->get() as $member)
                        @php
                            /** @var \App\Models\Member $member */
                            $attendance = $member->attendances()->where("event_id", $event->id)->first();
                            if($attendance === null) continue;
                            /** @var \App\Models\Attendance $attendance */
                            $cssClasses = $attendance?->attended ? " bg-green-300" : '';
                        @endphp
                        <div class="flex gap-2 items-center px-2">
                            <div class="h-2 w-2 rounded-full {{match($attendance?->poll_status){
                        "in" => 'bg-green-700',
                        "unsure" => 'bg-yellow-600',
                        "out" => 'bg-red-700',
                        default => ''} }}"></div>
                            <span class="rounded px-2 {{$cssClasses}}">{{__($member->getFullName())}}</span>
                        </div>
                    @empty
                        <span>{{__("Currently no attendance information.")}}</span>
                    @endforelse
                </div>
            </template>
        </div>
    </div>
</div>
