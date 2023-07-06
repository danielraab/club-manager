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
                <div class="grow px-5">{{__("promised")}}</div>
                <div class="text-green-900 font-bold text-xl">{{$statistics["in"]}}</div>
            </div>
            <div class="flex bg-white shadow-sm sm:rounded-lg p-5 items-center">
                <div class="text-white bg-orange-700 rounded-full w-10 h-10 flex justify-center items-center">
                    <i class="fa-solid fa-exclamation "></i>
                </div>
                <div class="grow px-5">{{__("unsure")}}</div>
                <div class="text-orange-900 font-bold text-xl">{{$statistics["unsure"]}}</div>
            </div>
            <div class="flex bg-white shadow-sm sm:rounded-lg p-5 items-center">
                <div class="text-white bg-red-700 rounded-full w-10 h-10 flex justify-center items-center">
                    <i class="fa-solid fa-xmark "></i>
                </div>
                <div class="grow px-5">{{__("cancelled")}}</div>
                <div class="text-red-900 font-bold text-xl">{{$statistics["out"]}}</div>
            </div>
            <div class="flex bg-white shadow-sm sm:rounded-lg p-5 items-center">
                <div class="text-white bg-blue-700 rounded-full w-10 h-10 flex justify-center items-center">
                    <i class="fa-solid fa-question "></i>
                </div>
                <div class="grow px-5">{{__("missing")}}</div>
                <div class="text-blue-900 font-bold text-xl">{{$statistics["unset"]}}</div>
            </div>

            <div class="flex bg-green-700 shadow-sm sm:rounded-lg p-5 items-center text-white">
                    <i class="fa-solid fa-check fa-2xl"></i>
                <div class="grow px-5">{{__("attended")}}</div>
                <div class="font-bold text-xl">{{$statistics["attended"]}}</div>
            </div>
        </div>

        <div class="flex bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 justify-center">
            <div>
            @foreach(\App\Models\MemberGroup::getTopLevelQuery()->get() as $memberGroup)
                <x-attendance.member-group-tree :memberGroup="$memberGroup" :event="$event"/>
            @endforeach
            </div>
        </div>
    </div>
</x-backend-layout>
