@php
    /** @var \App\Livewire\Forms\PollForm $pollForm */
    $hasAttendanceShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_SHOW_PERMISSION) ?? false;
    $hasAttendanceEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Attendance::ATTENDANCE_EDIT_PERMISSION) ?? false;
@endphp
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Event selection') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Select the events for the attendance poll.") }}
        </p>
    </header>

    <div class="mt-6 flex flex-col justify-center">

        <x-always-responsive-table class="table-auto mx-auto text-center">
            <tbody>
            @forelse(\App\Models\Event::query()->whereIn("id", $pollForm->selectedEvents)->orderBy("start")->get() as $event)
                @php
                /** @var \App\Models\Event $event */
                @endphp
                <tr class="[&:nth-child(2n)]:bg-opacity-50 bg-gray-300">
                    <td>{{$event->getFormattedStart()}}</td>
                    <td>{{$event->title}}</td>
                    <td class="whitespace-nowrap">
                        @if($hasAttendanceEditPermission)
                            <a href="{{route('event.attendance.edit', $event->id)}}"
                               title="{{__("Edit attendance of this event")}}"
                               class="inline-flex items-center text-cyan-900 p-0">
                                <i class="fa-solid fa-check-to-slot"></i>
                            </a>
                        @elseif($hasAttendanceShowPermission)
                            <a href="{{route('event.attendance.show', $event->id)}}"
                               title="{{__("Show attendance of this event")}}"
                               class="inline-flex items-center text-indigo-700 p-0">
                                <i class="fa-solid fa-square-poll-horizontal"></i>
                            </a>
                        @endif
                        <x-default-button type="button" title="Remove event selection"
                                          class="btn btn-danger"
                                          wire:click="removeEventFromSelection({{$event->id}})">
                            <i class="fa-solid fa-minus"></i>
                        </x-default-button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td>no events selected.</td>
                </tr>
            @endforelse
            </tbody>
        </x-always-responsive-table>
    </div>


    {{--  poll event selection --}}
    <div class="my-4">
        @php
        /** @var \Illuminate\Database\Eloquent\Collection $possibleEvents */
            $possibleEvents = $pollForm->showOnlyFutureEvents ?
                \App\Models\Event::getFutureEvents(false, true)->whereNotIn('id', $pollForm->selectedEvents)->get() :
                \App\Models\Event::query()->where("enabled", true)->orderBy("start")->whereNotIn('id', $pollForm->selectedEvents)->get();
        @endphp
        @if($possibleEvents->count() > 0)
            <x-input-label for="eventSelectionList" :value="__('Select an event to add:')"/>
            <select id="eventSelectionList" name="eventSelectionList" multiple size="5"
                    x-model="additionalEventList"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                @foreach($possibleEvents as $event)
                    @php /** @var \App\Models\Event $event*/ @endphp
                    <option value="{{$event->id}}">{{$event->getFormattedStart()}}
                        - {{$event->title}}</option>
                @endforeach
            </select>
        @else
            <div class="text-center text-gray-700">
                <span>{{__("No further events available.")}}</span>
            </div>
        @endif
            <div class="flex justify-center mt-2 gap-3">
                <x-input-checkbox id="show_only_future_events" name="show_only_future_events"
                                  wire:model.live="pollForm.showOnlyFutureEvents"
                                  class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    {{ __('only future events') }}
                </x-input-checkbox>
                <x-default-button type="button" class="btn btn-primary"
                                  x-bind:disabled="additionalEventList.length === 0"
                                  x-on:click="addEvents">{{__("Add events to poll")}}
                </x-default-button>
            </div>
    </div>



    @if($pollForm->poll?->created_at)
        <div class="text-gray-500 mt-3 ml-3">
            <i class="fa-regular fa-square-plus"></i>
            <span title="{{__("Creator")}}">{{$pollForm->poll?->creator?->name}}</span> -
            <span title="{{__("Created at")}}">{{$pollForm->poll?->created_at->formatDateTimeWithSec()}}</span>
        </div>
    @endif

    @if($pollForm->poll?->updated_at)
        <div class="text-gray-500 mt-2 ml-3">
            <i class="fa-solid fa-pencil"></i>
            <span title="{{__("Last updater")}}">{{ $pollForm->poll?->lastUpdater?->name }}</span> -
            <span title="{{__("Updated at")}}">{{ $pollForm->poll?->updated_at->formatDateTimeWithSec() }}</span>
        </div>
    @endif

</section>
