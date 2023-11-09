<?php
/** @var \App\Models\News $news */

$hasNewsEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\News::NEWS_EDIT_PERMISSION) ?? false;
?>
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex gap-3 items-center">
            <a href="{{route("news.index")}}">
                <i class="fa-solid fa-arrow-left-long"></i>
            </a>
            <span>{{ __('News Detail') }}</span>
        </div>
    </x-slot>

    <div class="flex justify-center">
        <div class="flex flex-col gap-3 bg-white shadow-sm sm:rounded-lg p-6 text-gray-900 max-w-xl justify-center">

            @if($hasNewsEditPermission)
                <div class="flex items-center justify-center gap-2">
                    <span class="text-gray-500">{{__("enabled")}}:</span>
                    <span
                        class="inline-block rounded-full h-5 w-5 {{$news->enabled ? "bg-green-700": "bg-red-700"}}"></span>
                    <span class="text-gray-500">{{__("logged in only")}}:</span>
                    <span
                        class="inline-block rounded-full h-5 w-5 {{$news->logged_in_only ? "bg-green-700": "bg-red-700"}}"></span>
                </div>
                <hr/>
            @endif
            <div class="text-center">
                <div class="text-gray-500">{{__("title")}}:</div>
                <div>{{$news->title}}</div>
            </div>
            @if($news->content)
                <div class="text-center">
                    <div class="text-gray-500">{{__("content")}}:</div>
                    <div>{{$news->content}}</div>
                </div>
            @endif
            <hr/>
            <div class="flex justify-center gap-5 ">
                <div class="text-gray-500">{{__("display until")}}:</div>
                <div class="font-bold text-lg">{{$news->display_until}}</div>
            </div>
        </div>
    </div>
</x-backend-layout>
