@php
    /** @var $event \App\Models\Event */
    /** @var $member \App\Models\Member */

    /** @var \App\Models\Attendance|null $attendance */
    $attendance = $event->attendances()->where("member_id", $member->id)->first();
@endphp
<div class="flex flex-col justify-between sm:flex-row py-2">
{{--    <x-livewire.loading/>--}}
    <div class="p-2">{{$member->getFullName()}}</div>
    <div class="flex justify-center gap-2">
        <div wire:click="recordPoll({{$attendance?->poll_status === "in" ? 'null' : "'in'"}})" title="{{__("In")}}"
             class="rounded-full w-10 h-10 flex justify-center items-center cursor-pointer
                        {{$attendance?->poll_status === "in" ? 'text-white bg-green-700' : 'text-green-700'}}">
            <i class="fa-solid fa-check "></i>
        </div>

        <div wire:click="recordPoll({{$attendance?->poll_status === "unsure" ? 'null' : "'unsure'"}})" title="{{__("Unsure")}}"
            class="rounded-full w-10 h-10 flex justify-center items-center cursor-pointer
                        {{$attendance?->poll_status === "unsure" ? 'text-white bg-yellow-700' : 'text-yellow-700'}}">
            <i class="fa-solid fa-exclamation "></i>
        </div>

        <div wire:click="recordPoll({{$attendance?->poll_status === "out" ? 'null' : "'out'"}})" title="{{__("Out")}}"
            class="rounded-full w-10 h-10 flex justify-center items-center cursor-pointer
                        {{$attendance?->poll_status === "out" ? 'text-white bg-red-700' : 'text-red-700'}}">
            <i class="fa-solid fa-xmark "></i>
        </div>


        <div class="border-r border-gray-500"></div>
        <div wire:click="recordAttend({{$attendance?->attended ? 'null' : 'true'}})" title="{{__("Attended")}}"
            class="rounded-lg w-10 h-10 flex justify-center items-center cursor-pointer
                        {{$attendance?->attended ? 'text-white bg-green-700' : 'text-green-700'}}">
            <i class="fa-solid fa-clipboard-check"></i>
        </div>
    </div>
</div>
