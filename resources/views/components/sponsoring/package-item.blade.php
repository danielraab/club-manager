@php
    /** @var $package \App\Models\Sponsoring\Package */
    /** @var $option \App\Models\Sponsoring\AdOption */
    /** @var $period \App\Models\Sponsoring\Period */
@endphp
<div class="relative border bg-blue-300 py-2 px-4 rounded-md @if(!$package->enabled) text-gray-500 @endif"
    x-data="{showOptions:true, showPeriods:false}"
>
    <div class="flex justify-between items-center">
        <h2 class="font-bold text-lg">{{$package->title}}</h2>
        @if(!$package->is_official)
            <div class="bg-red-700 text-white px-2 rounded-full text-sm">{{__("not official")}}</div>
        @endif
    </div>
    @if($package->description)
        <p class="text-gray-800 text-sm">{{$package->description}}</p>
    @endif

    <p class="mt-3">
        <span class="font-semibold inline-block min-w-[60px]">{{__("Ad Options")}}:</span>
        @if(($options = $package->adOptions()->get())->isNotEmpty())
            <ul class="list-disc pl-5 ml-2 text-sm">
                 @foreach($options as $option)
                     <li>{{$option->title}}</li>
                 @endforeach
            </ul>
        @else
            <div class="bg-red-700 text-white rounded px-3 py-1 my-4 inline-block">{{__("no ad options")}}</div>
        @endif
    </p>
    @if(($periods = $package->periods()->get())->isNotEmpty())
        <h3 @click="showPeriods=!showPeriods" class="font-semibold mt-3 cursor-pointer">
            <i class="fa-solid"
               :class="showPeriods ? 'fa-caret-down' : 'fa-caret-right'"></i>
            {{__("Periods")}}
        </h3>
        <ul class="list-disc pl-5 ml-2 text-sm" x-cloak x-show="showPeriods" x-collapse>
             @foreach($periods as $period)
                 <li>{{$period->title}}</li>
             @endforeach
        </ul>
    @else
        <div class="bg-orange-700 text-white rounded px-3 py-1 my-4 inline-block">{{__("No period use this package")}}</div>
    @endif
    @if($package->price)
        <p class="mt-3">{{\App\Facade\Currency::formatPrice($package->price)}}</p>
    @endif
    @if($hasEditPermission)
        <div class="absolute right-2 bottom-1">
            <a href="{{route('sponsoring.package.edit', $package->id)}}" title="Edit this package">
                <i class="fa-regular fa-pen-to-square"></i>
            </a>
        </div>
    @endif
</div>
