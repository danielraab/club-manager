@php
    /** @var $event \App\Models\Event */
    /** @var $members \Illuminate\Database\Eloquent\Collection */

    $memberFilter = $this->getMemberFilter();
    $hasEventEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Event::EVENT_EDIT_PERMISSION) ?? false;
@endphp

<x-slot name="headline">
    {{ __('Update event attendance') }}
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
            <a class="btn-info p-2 text-xs"
               href="{{ route('event.attendance.show', $event->id) }}">
                <i class="fa-solid fa-pen-to-square mr-2"></i>{{ __('Show Overview') }}
            </a>
            @if ($hasEventEditPermission)
                <a class="btn-primary p-2 text-xs"
                   href="{{ route('event.edit', $event->id) }}">
                    <i class="fa-solid fa-pen-to-square mr-2"></i>{{ __('Edit event') }}
                </a>
            @endif
        </div>
    </div>
</x-slot>

<div>
    <x-livewire.loading/>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex flex-wrap gap-2 items-center justify-between">
            <span class="text-gray-500">{{ $event->getFormattedStart() }}</span>
            <span class="text-gray-700 text-xl">{{ $event->title }}</span>
        </div>
    </div>

    <div class="flex justify-center gap-4 bg-white shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex items-center flex-wrap justify-center gap-5">
            <div class="flex items-center flex-wrap justify-center">
                @if($isDisplayGroup)
                    <div class="py-2 px-4 rounded-l-lg bg-sky-600">
                        {{__("Groups")}}</div>
                    <button type="button" wire:click="$set('isDisplayGroup', false)"
                            class="py-2 px-4 rounded-r-lg hover:bg-sky-500 bg-gray-300">
                        {{__("List")}}</button>
                @else
                    <button type="button" wire:click="$set('isDisplayGroup', true)"
                            class="py-2 px-4 rounded-l-lg hover:bg-sky-500 bg-gray-300">
                        {{__("Groups")}}</button>
                    <div class="py-2 px-4 rounded-r-lg bg-sky-600">
                        {{__("List")}}</div>
                @endif
            </div>
            <x-livewire.member-filter/>
        </div>
    </div>
    <div class="flex justify-center gap-4 bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        @if($isDisplayGroup)
            <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">
                @foreach (\App\Models\MemberGroup::getTopLevelQuery()->get() as $memberGroup)
                    <x-attendance.member-group-tree-record :memberGroup="$memberGroup" :event="$event"
                                                           initialShow="true"
                                                           wire:key="mgtr-{{ $event->id.'-'.$memberGroup->id }}"
                                                           :memberFilter="$memberFilter"/>
                @endforeach
            </div>
        @else
            <div class="flex flex-col justify-center text-center divide-y divide-gray-500">
                @foreach ($members->get() as $member)
                        <livewire:attendance.single-attendance :event="$event" :member="$member"
                                                               key="att-list-lw-{{ $event->id.'-'.$member->id }}"/>
                @endforeach
            </div>
        @endif
    </div>
</div>
