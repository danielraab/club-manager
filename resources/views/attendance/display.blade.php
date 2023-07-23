@php
    /** @var \App\Models\Event $event */
    $hasAttendanceEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_EDIT_PERMISSION) ?? false;
@endphp

<x-backend-layout>
    <x-slot name="headline">
        <div class="flex flex-wrap justify-between items-center gap-3">
            <span>{{ __('Attendance overview') }}</span>
        </div>
    </x-slot>

    <div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
            <div class="flex flex-wrap gap-2 items-center justify-between">
            <span
                class="text-gray-500">{{$event->start->setTimezone(config("app.displayed_timezone"))->isoFormat("ddd D. MMM YYYY HH:mm")}}</span>
                <span class="text-gray-700 text-xl">{{$event->title}}</span>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 justify-center mb-3">
            <div class="flex bg-white shadow rounded-lg p-5 items-center">
                <div class="text-white bg-green-700 rounded-full w-10 h-10 flex justify-center items-center">
                    <i class="fa-solid fa-check "></i>
                </div>
                <div class="grow px-5">{{__("promised")}}</div>
                <div class="text-green-900 font-bold text-xl">{{$statistics["in"]}}</div>
            </div>
            <div class="flex bg-white shadow rounded-lg p-5 items-center">
                <div class="text-white bg-yellow-600 rounded-full w-10 h-10 flex justify-center items-center">
                    <i class="fa-solid fa-question "></i>
                </div>
                <div class="grow px-5">{{__("unsure")}}</div>
                <div class="text-orange-900 font-bold text-xl">{{$statistics["unsure"]}}</div>
            </div>
            <div class="flex bg-white shadow rounded-lg p-5 items-center">
                <div class="text-white bg-red-700 rounded-full w-10 h-10 flex justify-center items-center">
                    <i class="fa-solid fa-xmark "></i>
                </div>
                <div class="grow px-5">{{__("cancelled")}}</div>
                <div class="text-red-900 font-bold text-xl">{{$statistics["out"]}}</div>
            </div>
            <div class="flex bg-white shadow rounded-lg p-5 items-center">
                <div class="text-white bg-blue-700 rounded-full w-10 h-10 flex justify-center items-center">
                    <i class="fa-solid fa-exclamation"></i>
                </div>
                <div class="grow px-5">{{__("missing")}}</div>
                <div class="text-blue-900 font-bold text-xl">{{$statistics["unset"]}}</div>
            </div>

            @if($statistics["attended"] && $statistics["attended"] > 0)
                <div class="flex bg-green-700 shadow rounded-lg p-5 items-center text-white">
                    <i class="fa-solid fa-check fa-2xl"></i>
                    <div class="grow px-5">{{__("attended")}}</div>
                    <div class="font-bold text-xl">{{$statistics["attended"]}}</div>
                </div>
            @endif
        </div>


        <div class="flex justify-center gap-4 bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
            <div class="flex items-center flex-wrap justify-center gap-5">
                <div class="inline-flex">
                    @if(request('displayType') === 'list')
                        <a href="?displayType=memberGroups" class="py-2 px-4 rounded-l-lg hover:bg-sky-500 bg-gray-300">
                            {{__("Groups")}}</a>
                        <div class="py-2 px-4 rounded-r-lg bg-sky-600">
                            {{__("List")}}</div>
                    @else
                        <div class="py-2 px-4 rounded-l-lg bg-sky-600">
                            {{__("Groups")}}</div>
                        <a href="?displayType=list" class="py-2 px-4 rounded-r-lg hover:bg-sky-500 bg-gray-300">
                            {{__("List")}}</a>
                    @endif
                </div>
                @if($hasAttendanceEditPermission)
                    <x-button-link class="btn-primary" href="{{route('event.attendance.edit', $event->id)}}">
                        {{__("Edit Attendance")}}
                    </x-button-link>
                @endif
            </div>
        </div>

        <div class="flex bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 justify-center">
            <div>
                @if(request('displayType') === 'list')
                    @foreach($event->attendances()->get() as $attendance)
                        @php
                            /** @var \App\Models\Attendance $attendance */
                                $cssClasses = $attendance->attended ? " bg-green-300" : '';
                        @endphp
                        <div class="flex gap-2 items-center px-2">
                            <div class="h-2 w-2 rounded-full {{match($attendance->poll_status){
                        "in" => 'bg-green-700',
                        "unsure" => 'bg-yellow-600',
                        "out" => 'bg-red-700',
                        default => ''} }}"></div>
                            <span
                                class="rounded px-2 {{$cssClasses}}">{{__($attendance->member()->first()->getFullName())}}</span>
                        </div>
                    @endforeach
                @else
                    @foreach(\App\Models\MemberGroup::getTopLevelQuery()->get() as $memberGroup)
                        <x-attendance.member-group-tree-display :memberGroup="$memberGroup" :event="$event"
                                                                initialShow="true"
                                                                :memberGroupCntList="$statistics['memberGroupStatistics']"/>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-backend-layout>
