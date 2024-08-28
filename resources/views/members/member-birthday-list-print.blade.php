<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <style>
        * {
            -webkit-print-color-adjust: exact !important;   /* Chrome, Safari 6 – 15.3, Edge */
            color-adjust: exact !important;                 /* Firefox 48 – 96 */
            print-color-adjust: exact !important;           /* Firefox 97+, Safari 15.4+ */
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" onload="window.print()">

    <!-- Page Heading -->
    <h2 class="font-semibold text-xl">
        <header>
            <div class="flex justify-center gap-5 items-center">
                <x-application-logo class="block h-10"/>
                <span>{{ __('Member Birthday list') }} - {{now()->format("Y")}}</span>
            </div>
        </header>
    </h2>

    <!-- Page Content -->
    <main>
        <div class="overflow-hidden mt-5">
            @if($members && $members->isNotEmpty())
                <ul class="columns-2 text-center text-sm">
                    @php($today = now()->format("m-d"))
                    @php($lastMonth = '')
                    @php($todayDisplayed = false)
                    @foreach($members as $member)
                        @if($lastMonth != $member->birthday->isoFormat("MMMM"))
                            @php($lastMonth = $member->birthday->isoFormat("MMMM"))
                            <li class="text-center font-bold bg-gray-400 px-3 py-1">{{$lastMonth}}</li>
                        @endif
                        <li class="flex justify-between w-full self-center">
                            <div class="px-4 py-1">{{ $member->lastname }} {{ $member->firstname }}</div>
                            <div class="px-4 py-1">{{ $member->birthday->isoFormat("D. MMMM") }}</div>
                            <div class="px-4 py-1">{{ now()->format("Y") - $member->birthday->format("Y") }}</div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="w-full text-center">{{__("no members")}}</div>
            @endif
        </div>
        @if($missingBirthdayList && $missingBirthdayList->isNotEmpty())
            <div class="overflow-hidden p-6 mt-5">
                <header>
                    <h2 class="font-medium">
                        {{ __('Missing birthdays') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Missing birthday entry for following members.") }}
                    </p>
                </header>
                <div class="m-5">
                    <ul class="list-disc columns-3">
                        @foreach($missingBirthdayList as $member)
                            <li>{{$member->lastname}} {{$member->firstname}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </main>
</body>
</html>

