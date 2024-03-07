@php
    /** @var \App\Models\AttendancePoll $poll */

    $hasEventEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Event::EVENT_EDIT_PERMISSION) ?? false;
    $hasAttendanceShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_SHOW_PERMISSION) ?? false;
    $hasAttendanceEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_EDIT_PERMISSION) ?? false;
    $hasPollShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION) ?? false;
    $hasPollEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION) ?? false;
@endphp

<x-slot name="headline">
    <div class="flex flex-wrap justify-between items-center gap-3">
        <span>{{ __('Attend poll') }}</span>
        <div>
            @if($hasPollShowPermission)
                <x-button-link href="{{route('attendancePoll.statistic', $poll->id)}}" class="btn btn-secondary"
                               title="Show summary of attendance poll">
                    {{__("Summary")}}
                </x-button-link>
            @endif
            @if($hasPollEditPermission)
                <x-button-link href="{{route('attendancePoll.edit', $poll->id)}}" class="btn btn-primary"
                               title="Edit this attendance poll">
                    {{__("Edit Poll")}}
                </x-button-link>
            @endif
        </div>
    </div>
</x-slot>

<div x-data="{selectedMember: @entangle('selectedMember'), resetSelected() {
    $wire.set('selectedMember', null);
    $wire.set('memberSelection', '');
}}">
    <x-livewire.loading/>
    <div class="bg-white over   flow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex flex-col">
            <span class="text-gray-700 text-xl">{{$poll->title}}</span>
            <span class="text-gray-500">{{$poll->description}}</span>
        </div>

        <div class="flex justify-center my-3">
            <div>
                <x-input-label for="memberSelection" :value="__('Member')"/>
                <div class="flex gap-3">
                    <select id="memberSelection" name="memberSelection"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1
                            disabled:text-gray-500"
                            wire:model.lazy="memberSelection"
                            required autofocus autocomplete="memberSelection"
                            @disabled($selectedMember !== null)>
                        <option></option>
                        @php
                            $memberList = new \Illuminate\Database\Eloquent\Collection();
                            /** @var \App\Models\MemberGroup $memberGroup */
                            $memberGroup = $poll->memberGroup()->first();

                            $beforeEntrance = \App\Models\Configuration::getBool(\App\Models\ConfigurationKey::POLL_PUBLIC_FILTER_BEFORE_ENTRANCE, null, false);
                            $afterRetired = \App\Models\Configuration::getBool(\App\Models\ConfigurationKey::POLL_PUBLIC_FILTER_AFTER_RETIRED, null, false);
                            $showPaused = \App\Models\Configuration::getBool(\App\Models\ConfigurationKey::POLL_PUBLIC_FILTER_SHOW_PAUSED, null, false);
                            $filter = new \App\Models\Filter\MemberFilter($beforeEntrance, $afterRetired, $showPaused);
                            if($memberGroup) {
                                $memberList = $memberGroup->getRecursiveMembers($filter);
                            } else {
                                $memberList = \App\Models\Member::getAllFiltered($filter)->get();
                            }
                        @endphp
                        @foreach($memberList as /** @var \App\Models\Member $member */ $member)
                            <option value="{{$member->id}}">{{$member->getFullName()}}</option>
                        @endforeach
                    </select>
                    <x-default-button type="button" class="btn btn-primary px-3 rounded" title="Clear selected member"
                                      x-on:click="resetSelected"
                                      :disabled="$selectedMember === null">x
                    </x-default-button>
                </div>
                @if($selectedMember === null)
                    <span class="text-xs text-gray-600">Start type in your name until you find it in the list.</span>
                @endif
                @error('member')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
        </div>
    </div>


    <div
            class="flex bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 justify-center">
        @if($selectedMember !== null)

            <div class="flex flex-col sm:table divide-y divide-gray-500">
                @foreach($poll->events()->where("end", ">", now())->orderBy('start')->get() as $event)
                    @php
                        /** @var \App\Models\Event $event */
                        /** @var \App\Models\Attendance|null $attendance */
                        $attendance = $event->attendances()->where("member_id", $selectedMember->id)->first();
                        $isPast = $event->start < now();
                    @endphp
                    <div class="flex flex-col sm:table-row gap-2 py-2 items-center">
                        <div class="text-gray-500 text-center sm:table-cell align-middle">
                            @if($hasEventEditPermission)
                                <a href="{{route('event.edit', $event->id)}}" title="Edit this event" class="px-3">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                            @endif
                            {{$event->getFormattedStart()}}
                        </div>
                        <div class="text-gray-700 text-center sm:table-cell px-3 align-middle">{{$event->title}}</div>

                        <div class="sm:table-cell">
                            <div class="flex justify-center gap-2">
                                @if($attendance?->poll_status === "in")
                                    <div title="{{__("In")}}"
                                         class="rounded-full w-10 h-10 flex justify-center items-center text-white bg-green-700">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                @else
                                    <div
                                            @if(!$isPast)
                                                wire:click="setAttendance({{$event->id}}, 'in')"
                                            @endif
                                            title="{{__("In")}}"
                                            class="rounded-full w-10 h-10 flex justify-center items-center @if(!$isPast) cursor-pointer @endif text-green-700">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                @endif

                                @if($attendance?->poll_status === "unsure")
                                    <div
                                            title="{{__("Unsure")}}"
                                            class="rounded-full w-10 h-10 flex justify-center items-center text-white bg-yellow-700">
                                        <i class="fa-solid fa-question"></i>
                                    </div>
                                @else
                                    <div
                                            @if(!$isPast)
                                                wire:click="setAttendance({{$event->id}}, 'unsure')"
                                            @endif
                                            title="{{__("Unsure")}}"
                                            class="rounded-full w-10 h-10 flex justify-center items-center @if(!$isPast) cursor-pointer @endif text-yellow-700">
                                        <i class="fa-solid fa-question"></i>
                                    </div>
                                @endif

                                @if($attendance?->poll_status === "out")

                                    <div title="{{__("Out")}}"
                                         class="rounded-full w-10 h-10 flex justify-center items-center text-white bg-red-700">
                                        <i class="fa-solid fa-xmark"></i>
                                    </div>
                                @else

                                    <div
                                            @if(!$isPast)
                                                wire:click="setAttendance({{$event->id}}, 'out')"
                                            @endif
                                            title="{{__("Out")}}"
                                            class="rounded-full w-10 h-10 flex justify-center items-center @if(!$isPast) cursor-pointer @endif text-red-700">
                                        <i class="fa-solid fa-xmark"></i>
                                    </div>

                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <span>Please select your name first.</span>
        @endif
    </div>
</div>
