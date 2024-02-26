@php
    /** @var $period \App\Models\Sponsoring\Period */
    /** @var $package \App\Models\Sponsoring\Package */
@endphp
<div
    class="relative border py-2 px-4 rounded-md @if($period->start > now()) bg-blue-600 @elseif($period->end < now()) bg-gray-300 @else bg-green-500 @endif"
    x-data="{showPackages:false}">
    <div class="flex justify-between items-center">
        <h2 class="font-bold">{{$period->title}}</h2>
    </div>
    @if($period->description)
        <p>{{$period->description}}</p>
    @endif
    @if(($packages = $period->packages()->where("enabled", true)->where("is_official", true)->get())->isNotEmpty())
        <h3 @click="showPackages=!showPackages" class="font-semibold mt-3">{{__("Packages")}}
            <i class="fa-solid"
               :class="showPackages ? 'fa-caret-down' : 'fa-caret-right'"></i>
        </h3>
        <ul class="list-disc pl-5" x-cloak x-show="showPackages" x-collapse>
            @foreach($packages as $package)
                <li>{{$package->title}}</li>
            @endforeach
        </ul>
    @else
        <div class="bg-red-700 text-white rounded px-3 py-1 my-4 inline-block">{{__("No packages")}}</div>
    @endif
    <p class="mt-3"><span
            class="font-semibold inline-block min-w-[60px]">{{__("Start")}}:</span>{{$period->start->formatDateOnly()}}
    </p>
    <p><span class="font-semibold inline-block min-w-[60px]">{{__("End")}}:</span>{{$period->end->formatDateOnly()}}</p>
    @if($hasShowPermission || $hasEditPermission)
        <div class="absolute right-2 bottom-1 flex items-center gap-3 m-1">
            <a href="{{route('sponsoring.period.adOption.overview', $period->id)}}" title="{{__("Show ad options overview for this periods")}}">
                <i class="fa-solid fa-images"></i>
            </a>
            <a href="{{route('sponsoring.period.backer.overview', $period->id)}}" title="{{__("Show period backer overview")}}">
                <i class="fa-solid fa-table-list"></i>
            </a>
            @if($hasEditPermission)
                <a href="{{route('sponsoring.period.edit', $period->id)}}" title="{{__("Edit this period")}}">
                    <i class="fa-regular fa-pen-to-square"></i>
                </a>
            @endif
        </div>
    @endif
</div>
