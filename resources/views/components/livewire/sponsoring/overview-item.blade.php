@php
    /** @var $backer \App\Models\Sponsoring\Backer */
    /** @var $showDetails bool */
@endphp
<div class="border py-3 px-5 [&:nth-child(2n)]:bg-opacity-50
 {{!$backer->enabled || $backer->closed_at ? 'bg-gray-300 text-gray-500' : 'bg-purple-300'}}">
    <div class="flex justify-between cursor-pointer items-center"
         wire:click="$toggle('showDetails')">
        <div>
            <span class="font-semibold max-sm:block">{{$backer->name}}</span>
            <span class="text-gray-500">&nbsp;-&nbsp;{{$backer->zip}} {{$backer->city}}</span>
        </div>
        @if($showDetails)
            <i class="fa-solid fa-minus"></i>
        @else
            <i class="fa-solid fa-plus"></i>
        @endif
    </div>
    @if($showDetails)
        <div class="p-3 grid grid-cols-1 md:grid-cols-2">
            <div><span class="font-bold">{{__("contact person")}}: </span>{{$backer->contact_person}}</div>
            <div><span class="font-bold">{{__("mail")}}: </span>{{$backer->email}}</div>
            <div><span class="font-bold">{{__("address")}}: </span>{{$backer->street}}, {{$backer->zip}} {{$backer->city}}</div>
            <div><span class="font-bold">{{__("phone")}}: </span>{{$backer->phone}}</div>
            <div><span class="font-bold">{{__("info")}}: </span>{{$backer->info}}</div>
            @if($backer->closed_at)
                <div><span class="font-bold">{{__("closed")}}: </span>{{$backer->closed_at}}</div>
            @endif
        </div>
        <div class="text-right">
            <a href="{{route('sponsoring.backer.edit', $backer->id)}}" title="Edit this backer">
                <i class="fa-regular fa-pen-to-square"></i>
            </a>
        </div>
    @endif
</div>
