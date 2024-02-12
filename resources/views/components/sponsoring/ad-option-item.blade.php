<div class="relative border bg-amber-300 py-2 px-4 rounded-md @if(!$adOption->enabled) text-gray-700 @endif">
    <p class="font-bold">{{$adOption->title}}</p>
    @if($adOption->description)
        <p>{{$adOption->description}}</p>
    @endif
    @if($adOption->price)
        <p>{{\App\Facade\Currency::formatPrice($adOption->price)}}</p>
    @endif
    @if($hasEditPermission)
        <div class="absolute right-2 bottom-1">
            <a href="{{route('sponsoring.ad-option.edit', $adOption->id)}}" title="Edit this ad option">
                <i class="fa-regular fa-pen-to-square"></i>
            </a>
        </div>
    @endif
</div>
