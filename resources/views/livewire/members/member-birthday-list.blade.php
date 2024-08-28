<x-slot name="headline">
    <span>{{ __('Member Birthday list') }} - {{now()->format("Y")}}</span>
</x-slot>
<x-slot name="headerBtn">
    <x-button-dropdown>
        <x-slot name="mainButton">
            <a href='{{route("member.birthdayList.print")}}'
               class="p-2 text-xs flex">
                <i class="fa-solid fa-print mr-2"></i>{{__("Print")}}
            </a>
        </x-slot>
        <a href='{{route("member.birthdayList.print", ["printMissing"=>true])}}'
           class="inline-flex items-center p-2 hover:cursor-pointer text-xs">
            <i class="fa-solid fa-print mr-2"></i>{{__("Print with missing")}}
        </a>
    </x-button-dropdown>
</x-slot>

<div>
    <x-livewire.filter.member-filter/>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg lg:p-6 text-gray-900 my-5">
        @if($members && $members->isNotEmpty())
            <div class="flex flex-col divide-y">
                @php($today = now()->format("m-d"))
                @php($lastMonth = '')
                @php($todayDisplayed = false)
                @foreach($members as $member)
                    @if($lastMonth != $member->birthday->isoFormat("MMMM"))
                        @php($lastMonth = $member->birthday->isoFormat("MMMM"))
                        <div class="text-center font-bold bg-gray-300 px-3 py-1">{{$lastMonth}}</div>
                    @endif
                    @php($current = $member->birthday->format("m-d"))
                    @if(!$todayDisplayed && strcmp($today, $current) < 0)
                        <div class="relative py-4">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-b border-black"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span
                                    class="bg-indigo-700 text-white px-4 border border-black rounded">{{__('Today')}} - {{now()->isoFormat("D. MMMM")}}</span>
                            </div>
                        </div>
                        @php($todayDisplayed = true)
                    @endif
                    <div class="flex justify-between max-w-xl w-full self-center">
                        <div class="px-4 py-2">{{ $member->lastname }} {{ $member->firstname }}</div>
                        <div class="px-4 py-2">{{ $member->birthday->isoFormat("D. MMMM") }}</div>
                        <div class="px-4 py-2">{{ now()->format("Y") - $member->birthday->format("Y") }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="w-full text-center">{{__("no members")}}</div>
        @endif
    </div>
    @if($missingBirthdayList && $missingBirthdayList->isNotEmpty())
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Missing birthdays') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __("Missing birthday entry for following members.") }}
                </p>
            </header>
            <div class="m-5">
                <ul class="list-disc">
                    @foreach($missingBirthdayList as $member)
                        <li>{{$member->lastname}} {{$member->firstname}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
