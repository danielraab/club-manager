@php
    /** @var \App\Models\AttendancePoll $poll */

    $hasEventEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Event::EVENT_EDIT_PERMISSION) ?? false;
    $hasAttendanceShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_SHOW_PERMISSION) ?? false;
    $hasAttendanceEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_EDIT_PERMISSION) ?? false;
    $hasPollShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION) ?? false;
    $hasPollEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION) ?? false;
@endphp

<x-slot name="headline">
    <span>{{ __('Attendance poll') }}</span>
</x-slot>
<x-slot name="headerBtn">
    <div class="space-x-2">
        @if($hasPollShowPermission || $poll->show_public_stats)
            <a href="{{route('attendancePoll.statistic', $poll->id)}}" class="btn btn-secondary inline-flex gap-2 items-center"
               title="Show summary of attendance poll">
                <i class="fa-solid fa-clipboard-list"></i>
                <span class="max-sm:hidden">{{__("Summary")}}</span>
            </a>
        @endif
        @if($hasPollEditPermission)
            <a href="{{route('attendancePoll.edit', $poll->id)}}" class="btn btn-primary inline-flex gap-2 items-center"
               title="Edit this attendance poll">
                <i class="fa-solid fa-pen-to-square"></i>
                <span class="max-sm:hidden">{{__("Edit Poll")}}</span>
            </a>
        @endif
    </div>
</x-slot>

<div>
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
                    <x-select id="memberSelection" name="memberSelection"
                              class="block mt-1"
                              wire:model.lazy="memberSelection"
                              required autofocus autocomplete="memberSelection"
                              :disabled="$selectedMember != null">
                        <option value=""></option>
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
                            /** @var \App\Models\Member $member */
                        @endphp
                        @foreach($memberList as $member)
                            <option value="{{$member->id}}">{{$member->getFullName()}}</option>
                        @endforeach
                    </x-select>
                    <button type="button" class="btn btn-primary px-3 rounded" title="Clear selected member"
                            wire:click="resetSelected" @if($selectedMember == null) disabled @endif>x
                    </button>
                </div>
                @if($selectedMember === null)
                    <span class="text-xs text-gray-600">{{__('Start type in your name until you find it in the list.')}}</span>
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
                @foreach($poll->events()->where('enabled', true)->where('end', '>', now())->orderBy('start')->get() as $event)
                    @php
                        /** @var \App\Models\Event $event */
                        /** @var \App\Models\Attendance|null $attendance */
                        $attendance = $event->attendances()->where("member_id", $selectedMember->id)->first();
                        $isPast = $event->start < now();
                    @endphp
                    <div class="flex flex-col sm:table-row gap-2 py-2 items-center">
                        <div class="text-gray-500 text-center sm:table-cell align-middle">
                            @if($hasEventEditPermission)
                                <a href="{{route('event.edit', $event->id)}}" title="Edit this event" class="btn btn-primary mr-2">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                            @endif
                            {{$event->getFormattedStart()}}
                        </div>
                        <div class="text-gray-700 text-center sm:table-cell px-3 align-middle">{{$event->title}}</div>

                        <div class="sm:table-cell">
                            <livewire:attendance.single-public-attendance :event="$event" :member="$selectedMember"
                                                                          key="att-list-e-{{ $event->id }}"/>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <span>{{__('Please select your name first.')}}</span>
        @endif
    </div>
</div>
