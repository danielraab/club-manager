<x-backend-layout>
    <x-slot name="headline">
        <div class="flex flex-wrap justify-between items-center">
            <span>{{ __('Attendance overview') }}</span>
            <span class="text-gray-400">{{$event->title}}</span>
        </div>
    </x-slot>

    <div>
        <div class="flex flex-wrap gap-3 justify-center mb-3">
            <div class="flex bg-white shadow-sm sm:rounded-lg p-5 items-center">
                <div class="text-white bg-green-700 rounded-full w-10 h-10 flex justify-center items-center">
                    <i class="fa-solid fa-check "></i>
                </div>
                <div class="grow px-5">In</div>
                <div class="text-gray-600 font-bold">8</div>
            </div>
            <div class="flex bg-white shadow-sm sm:rounded-lg p-5 items-center">
                <div class="text-white bg-orange-700 rounded-full w-10 h-10 flex justify-center items-center">
                    <i class="fa-solid fa-exclamation "></i>
                </div>
                <div class="grow px-5">unsure</div>
                <div class="text-gray-600 font-bold">8</div>
            </div>
            <div class="flex bg-white shadow-sm sm:rounded-lg p-5 items-center">
                <div class="text-white bg-red-700 rounded-full w-10 h-10 flex justify-center items-center">
                    <i class="fa-solid fa-xmark "></i>
                </div>
                <div class="grow px-5">Out</div>
                <div class="text-gray-600 font-bold">8</div>
            </div>
            <div class="flex bg-white shadow-sm sm:rounded-lg p-5 items-center">
                <div class="text-white bg-blue-700 rounded-full w-10 h-10 flex justify-center items-center">
                    <i class="fa-solid fa-question "></i>
                </div>
                <div class="grow px-5">missing</div>
                <div class="text-gray-600 font-bold">8</div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
            @php($memberGroupDataList = [
    [
        "memberGroup" => \App\Models\MemberGroup::getTopLevelQuery()->first(),
        "statistics" => [
            "in" => 1,
            "unsure" => 2,
            "out" => 3
        ]
    ],
    [
        "memberGroup" => \App\Models\MemberGroup::getTopLevelQuery()->first(),
                "statistics" => [
            "in" => 1,
            "unsure" => 2,
            "out" => 3
        ]
    ]
])
            @foreach($memberGroupDataList as $memberGroupData)
                <x-attendance.member-group-tree :memberGroupData="$memberGroupData"/>
            @endforeach
        </div>
    </div>
</x-backend-layout>
