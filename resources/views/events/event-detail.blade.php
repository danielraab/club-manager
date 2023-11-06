<?php
/** @var \App\Models\Event $event */
?>
<x-backend-layout>
    <x-slot name="headline">
        <span>{{ __('Event Detail') }}</span>
    </x-slot>

    <div class="flex justify-center">
        <div class="flex flex-col gap-3 bg-white shadow-sm sm:rounded-lg p-6 text-gray-900 max-w-xl justify-center">

            <div class="flex items-center justify-center gap-2">
                <span class="text-gray-500">{{__("enabled")}}:</span>
                <span
                    class="inline-block rounded-full h-5 w-5 {{$event->enabled ? "bg-green-700": "bg-red-700"}}"></span>
                <span class="text-gray-500">{{__("logged in only")}}:</span>
                <span
                    class="inline-block rounded-full h-5 w-5 {{$event->logged_in_only ? "bg-green-700": "bg-red-700"}}"></span>
            </div>
            <hr />
            <div class="text-center">
                <div class="text-gray-500">{{__("title")}}:</div>
                <div class="font-bold text-lg">{{$event->title}}</div>
            </div>
            <div class="flex justify-center gap-4">
                <div>
                    <div class="text-gray-500">{{__("start")}}:</div>
                    <div class="font-bold text-lg">{{$event->getFormattedStart()}}</div>
                </div>
                <div>
                    <div class="text-gray-500">{{__("end")}}:</div>
                    <div class="font-bold text-lg">{{$event->getFormattedEnd()}}</div>
                </div>
            </div>
            <hr />
            <div class="text-center">
                <div class="text-gray-500">{{__("description")}}:</div>
                <div>{{$event->description}}</div>
            </div>

            <?php $eventType = $event->eventType()->first()->title ?>
            @if($eventType)
                <div class="text-center">
                    <div class="text-gray-500">{{__("type")}}:</div>
                    <div>{{$eventType}}</div>
                </div>
            @endif

            <div class="text-center">
                <div class="flex gap-2 items-center justify-center text-gray-500">
                    <i class="fa-solid fa-location-dot"></i>
                    {{__("location")}}:
                </div>
                <div>{{$event->location}}</div>
            </div>
            <div class="text-center">
                <div class="flex gap-2 items-center justify-center text-gray-500">
                    <i class="fa-solid fa-shirt"></i>
                    {{__("dress code")}}:
                </div>
                <div>{{$event->dress_code}}</div>
            </div>
            <div class="text-center">
                <div class="flex gap-2 items-center justify-center text-gray-500">
                    <i class="fa-solid fa-link"></i>
                    {{__("link")}}:
                </div>
                <a href="{{$event->link}}">{{$event->link}}</a>
            </div>
        </div>
    </div>
</x-backend-layout>
