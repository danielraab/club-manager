@php
    /** @var $event \App\Models\Event */
    /** @var $member \App\Models\Member */

    /** @var \App\Models\Attendance|null $attendance */
    $attendance = $event->attendances()->where("member_id", $member->id)->first();
    $isPast = $event->start < now();
    $cssPast = "cursor-pointer";
    if($isPast) $cssPast = "opacity-50"
@endphp
<div class="flex justify-center gap-2">
    <div
        @if(!$isPast)
            wire:click="recordPoll({{$attendance?->poll_status === "in" ? 'null' : "'in'"}})"
        @endif
        title="{{__("In")}}"
        class="rounded-full w-10 h-10 flex justify-center items-center {{$cssPast}}
                        {{$attendance?->poll_status === "in" ? 'text-white bg-green-700' : 'text-green-700'}}">
        <i class="fa-solid fa-check"></i>
    </div>

    <div
        @if(!$isPast)
            wire:click="recordPoll({{$attendance?->poll_status === "unsure" ? 'null' : "'unsure'"}})"
        @endif
        title="{{__("Unsure")}}"
        class="rounded-full w-10 h-10 flex justify-center items-center {{$cssPast}}
                        {{$attendance?->poll_status === "unsure" ? 'text-white bg-yellow-700' : 'text-yellow-700'}}">
        <i class="fa-solid fa-question"></i>
    </div>

    <div
        @if(!$isPast)
            wire:click="recordPoll({{$attendance?->poll_status === "out" ? 'null' : "'out'"}})"
        @endif
        title="{{__("Out")}}"
        class="rounded-full w-10 h-10 flex justify-center items-center {{$cssPast}}
                        {{$attendance?->poll_status === "out" ? 'text-white bg-red-700' : 'text-red-700'}}">
        <i class="fa-solid fa-xmark"></i>
    </div>

    @if($isPast)
        <div class="border-r border-gray-500"></div>
        <div
            title="{{__("Attended")}}"
            class="rounded-lg w-10 h-10 flex justify-center items-center {{$cssPast}}
                        {{$attendance?->attended ? 'text-white bg-green-700' : 'text-green-700'}}">
            <i class="fa-solid fa-clipboard-check"></i>
        </div>
    @endif

    <div wire:loading.flex
         class="flex flex-row justify-center items-center absolute left-0 right-0 top-0 bottom-0 select-none z-50 bg-gray-300 opacity-50">
        <i class="fa-solid fa-spinner fa-spin-pulse text-lg"></i>
    </div>
</div>
