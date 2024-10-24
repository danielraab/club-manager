@php
    /** @var $backer \App\Models\Sponsoring\Backer */
    /** @var $showDetails bool */
@endphp
<x-accordion
    class="[&:nth-child(2n)]:bg-opacity-50
    {{!$backer->enabled || $backer->closed_at ? 'bg-gray-300 text-gray-500' : 'bg-purple-300'}}">

    <x-slot name="labelSlot">
        <div>
            <span class="font-semibold max-sm:block">{{$backer->name}}</span>
            @if($backer->city)
                <span class="text-gray-500">&nbsp;-&nbsp;{{$backer->zip}} {{$backer->city}}</span>
            @endif
        </div>
    </x-slot>
    <div>
        <div class="px-5 py-2 grid grid-cols-1 md:grid-cols-2">
            <div><span class="font-bold">{{__("contact person")}}: </span>{{$backer->contact_person}}</div>
            <div><span class="font-bold">{{__("mail")}}: </span>{{$backer->email}}</div>
            <div><span class="font-bold">{{__("address")}}: </span>{{$backer->street}}
                , {{$backer->zip}} {{$backer->city}}</div>
            <div><span class="font-bold">{{__("phone")}}: </span>{{$backer->phone}}</div>
            @if($backer->info)
                <div><span class="font-bold">{{__("info")}}: </span>{{$backer->info}}</div>
            @endif
            @if($backer->vat)
                <div><span class="font-bold">{{__("vat")}}: </span>{{$backer->vat}}</div>
            @endif
            @if($backer->closed_at)
                <div><span class="font-bold">{{__("closed")}}: </span>{{$backer->closed_at}}</div>
            @endif
            <x-sponsoring.backer-contract-list :backer="$backer"/>
        </div>
        @if($hasEditPermission)
            <div class="text-right mb-2">
                <a href="{{route('sponsoring.backer.edit', $backer->id)}}" title="Edit this backer">
                    <i class="fa-regular fa-pen-to-square"></i>
                </a>
            </div>
        @endif
    </div>
</x-accordion>
