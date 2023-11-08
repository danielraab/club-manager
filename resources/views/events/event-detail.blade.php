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
                    <span class="text-gray-500">{{__("enabled")}}:</span>
                    <span
                        class="inline-block rounded-full h-5 w-5 {{$event->enabled ? "bg-green-700": "bg-red-700"}}"></span>
                    <span class="text-gray-500">{{__("logged in only")}}:</span>
                    <span
                        class="inline-block rounded-full h-5 w-5 {{$event->logged_in_only ? "bg-green-700": "bg-red-700"}}"></span>
                </div>
                <hr/>
            @endif
            <div class="text-center">
                <div class="text-gray-500">{{__("title")}}:</div>
                <div class="font-bold text-lg">{{$event->title}}</div>
            </div>
            <div class="flex justify-center gap-5 ">
                <div>
                    <div class="text-gray-500">{{__("start")}}:</div>
                    <div class="font-bold text-lg">{{$event->getFormattedStart()}}</div>
                </div>
                <div class="bg-gray-400 w-px shrink-0"></div>
                <div>
                    <div class="text-gray-500">{{__("end")}}:</div>
                    <div class="font-bold text-lg">{{$event->getFormattedEnd()}}</div>
                </div>
            </div>
            <hr class="border-gray-400"/>
            @if($event->description)
                <div class="text-center">
                    <div class="text-gray-500">{{__("description")}}:</div>
                    <div>{{$event->description}}</div>
                </div>
            @endif

            <?php $eventType = $event->eventType()->first()->title ?>
            @if($eventType)
                <div class="text-center">
                    <div class="text-gray-500">{{__("type")}}:</div>
                    <div>{{$eventType}}</div>
                </div>
            @endif
            @if($event->location)
                <div class="text-center">
                    <div class="flex gap-2 items-center justify-center text-gray-500">
                        <i class="fa-solid fa-location-dot"></i>
                        {{__("location")}}:
                    </div>
                    <div>{{$event->location}}</div>
                </div>
            @endif
            @if($event->dress_code)
                <div class="text-center">
                    <div class="flex gap-2 items-center justify-center text-gray-500">
                        <i class="fa-solid fa-shirt"></i>
                        {{__("dress code")}}:
                    </div>
                    <div>{{$event->dress_code}}</div>
                </div>
            @endif
            @if($event->link)
                <div class="text-center">
                    <div class="flex gap-2 items-center justify-center text-gray-500">
                        <i class="fa-solid fa-link"></i>
                        {{__("link")}}:
                    </div>
                    <a href="{{$event->link}}">{{$event->link}}</a>
                </div>
            @endif
        </div>
    </div>
</x-backend-layout>
