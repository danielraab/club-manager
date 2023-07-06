@php
$currentMemberGroup = $memberGroupData["memberGroup"];
$statistics = $memberGroupData["statistics"];
@endphp
<!-- Accordion Wrapper -->
<div x-data="{show:false}" class="transition hover:bg-indigo-50" :class="show ? 'bg-indigo-50':''">
    <!-- header -->
    <div x-on:click="show= !show"
        class="cursor-pointer transition flex justify-between sm:justify-start space-x-4 px-5 items-center">
        <div class="flex items-center gap-2">
            <i class="fas " :class="show ? 'fa-minus':'fa-plus'"></i>
            <h3>{{__($currentMemberGroup->title)}}</h3>
        </div>
        <div class="flex">
            <div class="text-white text-xs bg-green-700 rounded-full w-6 h-6 flex justify-center items-center">{{$statistics["in"]}}</div>
            <div class="text-white text-xs bg-orange-700 rounded-full w-6 h-6 flex justify-center items-center">{{$statistics["unsure"]}}</div>
            <div class="text-white text-xs bg-red-700 rounded-full w-6 h-6 flex justify-center items-center">{{$statistics["out"]}}</div>
        </div>
    </div>
    <!-- Content -->
    <div x-show="show" class="px-5 pt-0 overflow-hidden" x-transition.duration.500ms>
        {{$slot}}
    </div>
</div>
