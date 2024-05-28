<?php
/** @var \App\Models\Event $event */

$hasEventEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Event::EVENT_EDIT_PERMISSION) ?? false;
?>
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex gap-3 items-center">
            <a href="{{route("event.index")}}">
                <i class="fa-solid fa-arrow-left-long"></i>
            </a>
            <span>{{ __('Event Detail') }}</span>
        </div>
    </x-slot>

    <div class="flex justify-center">
        <div class="flex flex-col gap-3 bg-white shadow-sm sm:rounded-lg p-6 text-gray-900 max-w-xl justify-center">

            @if($hasEventEditPermission)
                <div class="flex items-center justify-center gap-2">
                    @if($event->enabled)
                        <span class="bg-green-700 text-white px-2 rounded">{{__("enabled")}}</span>
                    @else
                        <span class="bg-red-700 text-white px-2 rounded">{{__("disabled")}}</span>
                    @endif
                    @if($event->logged_in_only)
                        <span class="bg-red-700 text-white px-2 rounded">{{__("logged in only")}}</span>
                    @else
                        <span class="bg-green-700 text-white px-2 rounded">{{__("public")}}</span>
                    @endif
                </div>
                <hr/>
            @endif
            <div class="text-center">
                <div class="text-gray-500">{{__("Title")}}:</div>
                <div class="font-bold text-lg">{{$event->title}}</div>
            </div>
            <div class="flex justify-center gap-5 ">
                <div>
                    <div class="text-gray-500">{{__("Start")}}:</div>
                    <div class="font-bold text-lg">{{$event->getFormattedStart()}}</div>
                </div>
                <div class="bg-gray-400 w-px shrink-0"></div>
                <div>
                    <div class="text-gray-500">{{__("End")}}:</div>
                    <div class="font-bold text-lg">{{$event->getFormattedEnd()}}</div>
                </div>
            </div>
            <hr class="border-gray-400"/>
            @if($event->description)
                <div class="text-center">
                    <div class="text-gray-500">{{__("Description")}}:</div>
                    <div>{{$event->description}}</div>
                </div>
            @endif

            <?php $eventType = $event->eventType()->first()->title ?>
            @if($eventType)
                <div class="text-center">
                    <div class="text-gray-500">{{__("Type")}}:</div>
                    <div>{{$eventType}}</div>
                </div>
            @endif
            @if($event->location)
                <div class="text-center">
                    <div class="flex gap-2 items-center justify-center text-gray-500">
                        <i class="fa-solid fa-location-dot"></i>
                        {{__("Location")}}:
                    </div>
                    <div>{{$event->location}}</div>
                </div>
            @endif
            @if($event->dress_code)
                <div class="text-center">
                    <div class="flex gap-2 items-center justify-center text-gray-500">
                        <i class="fa-solid fa-shirt"></i>
                        {{__("Dress code")}}:
                    </div>
                    <div>{{$event->dress_code}}</div>
                </div>
            @endif
            @if($event->link)
                <div class="text-center">
                    <div class="flex gap-2 items-center justify-center text-gray-500">
                        <i class="fa-solid fa-link"></i>
                        {{__("Link")}}:
                    </div>
                    <a href="{{$event->link}}">{{$event->link}}</a>
                </div>
            @endif

            @php($member = auth()->user()?->getMember())
            @if($member)
                <hr class="border-gray-400"/>
                <div class="text-center">
                    <header class="mb-3">
                        <span class="font-bold">{{__('record attendace for')}}:</span>
                        {{$member->getFullName()}}
                    </header>
                    <livewire:attendance.single-public-attendance :event="$event" :member="$member"/>
                </div>
            @endif
        </div>
    </div>
</x-backend-layout>
