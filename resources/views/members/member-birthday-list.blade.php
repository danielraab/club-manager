<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <span>{{ __('Member Birthday list') }}</span>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
        @if($members && $members->isNotEmpty())
            <x-always-responsive-table class="table-auto mx-auto text-center">
                <thead class="font-bold">
                <tr>
                    <td class="px-4 py-2">Name</td>
                    <td class="px-4 py-2">{{__("Birthday")}}</td>
                    <td class="px-4 py-2">{{__("Age")}}</td>
                </tr>
                </thead>
                <tbody>
                @php($today = now()->format("m-d"))
                @php($todayDisplayed = false)
                @foreach($members as $member)
                    @php($current = $member->birthday->format("m-d"))
                    @if(!$todayDisplayed && strcmp($today, $current) <= 0)
                        <tr>
                            <td colspan="3">
                                <div class="relative py-4">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-b border-black"></div>
                                    </div>
                                    <div class="relative flex justify-center">
                                        <span
                                            class="bg-indigo-700 text-white px-4 border border-black rounded">{{__('Today')}} - {{now()->isoFormat("D. MMMM")}}</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @php($todayDisplayed = true)
                    @endif
                    <tr class="[&:nth-child(2n)]:bg-indigo-200">
                        <td class="border px-4 py-2">{{ $member->lastname }} {{ $member->firstname }}</td>
                        <td class="border px-4 py-2">{{ $member->birthday->isoFormat("D. MMMM") }}</td>
                        <td class="border px-4 py-2">{{ now()->format("Y") - $member->birthday->format("Y") }}</td>
                    </tr>
                @endforeach
                </tbody>
            </x-always-responsive-table>
        @else
            <div class="w-full text-center">{{__("No members")}}</div>
        @endif
    </div>
    @if($missingBirthdayList && $missingBirthdayList->isNotEmpty())
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 mt-5">

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
</x-backend-layout>
