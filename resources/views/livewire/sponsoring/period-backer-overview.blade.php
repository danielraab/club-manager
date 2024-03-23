@php
    /** @var $period \App\Models\Sponsoring\Period */
    /** @var $backer \App\Models\Sponsoring\Backer */
    /** @var $periodFile \App\Models\UploadedFile */

    $green = "text-green-700";
    $yellow = "text-yellow-600";
    $red = "text-red-600";
    $gray = "text-gray-400";

@endphp
<x-slot name="headline">
    <div class="flex items-center gap-2">
        <a href="{{route("sponsoring.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        <span class="text-gray-500">{{__("Period")}}:</span> {{$period->title}}
    </div>
</x-slot>

<div x-init="$store.notificationMessages
        .addNotificationMessages(
        JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))">
    <x-livewire.loading/>
    @if($hasEditPermission && $period->end > now())
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3 p-5 gap-2 flex justify-end items-center">

            <div class="flex items-center gap-2" x-data="{showLegend:false}">
                <button type="button" x-ref="legendBtn" class="" x-on:click="showLegend= !showLegend">
                    <i class="fa-solid fa-circle-info text-blue-700"></i>
                </button>
                <div x-anchor="$refs.legendBtn" x-show="showLegend" x-cloak x-on:click.outside="showLegend = false"
                     class="z-10 bg-white rounded px-5 py-2 border border-black m-1 shadow-xl divide-y">
                    <div class="flex items-center gap-1">
                        <i class="fa-solid fa-circle-info text-cyan-900"></i>
                        <span>{{__("show contract details")}}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <i class="fa-solid fa-user {{$green}}"></i>
                        <i class="fa-solid fa-user {{$red}}"></i>
                        <span>{{__("contract has/has no member")}}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <i class="fa-solid fa-ban {{$red}}"></i>
                        <i class="fa-solid fa-ban {{$gray}}"></i>
                        <span>{{__("contract is/is no declined")}}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <i class="fa-solid fa-cube {{$green}}"></i>
                        <i class="fa-solid fa-cube {{$gray}}"></i>
                        <span>{{__("package is/is no selected")}}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <i class="fa-solid fa-file-contract {{$green}}"></i>
                        <i class="fa-solid fa-file-contract {{$yellow}}"></i>
                        <i class="fa-solid fa-file-contract {{$gray}}"></i>
                        <span>{{__("contract is uploaded/received/or neither")}}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <i class="fa-regular fa-image {{$green}}"></i>
                        <i class="fa-regular fa-image text-blue-700"></i>
                        <span>{{__("ad data is available and up to date/not up to date")}}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <i class="fa-regular fa-image {{$yellow}}"></i>
                        <i class="fa-regular fa-image {{$gray}}"></i>
                        <span>{{__("ad data is transmitted/not transmitted")}}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <i class="fa-solid fa-money-bill-wave {{$green}}"></i>
                        <i class="fa-solid fa-money-bill-wave {{$gray}}"></i>
                        <span>{{__("backer has/has not paid")}}</span>
                    </div>
                </div>

            </div>
            <x-button-dropdown>
                <x-slot name="mainButton">
                    <a href="{{route('sponsoring.period.edit', $period->id)}}" class="btn-primary p-2 text-xs"
                       title="Edit this period">
                        <i class="fa-solid fa-pen-to-square mr-2"></i>
                        {{__("Edit period")}}
                    </a>
                </x-slot>
                <button type="button"
                        wire:confirm.prompt="{{__('Do you want to generate a contract for every backer ?')}}"
                        wire:click="generateAllContracts" title="Generate a contract for every backer."
                        class="btn-secondary p-2 text-xs">{{ __('Generate contracts') }}</button>
            </x-button-dropdown>
        </div>
    @endif

    @if(($periodFiles = $period->uploadedFiles()->get())->isNotEmpty())
        <div class="flex flex-wrap mb-5 mx-2">
            <span>{{__("Period files:")}}</span>
            <ul class="list-disc flex flex-wrap mx-2">
                @foreach($periodFiles as $periodFile)
                    <li class="mx-3"><a href="{{$periodFile->getUrl()}}" target="_blank"
                                        class="underline mr-2">{{$periodFile->name}}</a>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow-sm sm:rounded-lg p-5">
        <div class="divide-y divide-black">
            @forelse($backerList["enabled"] as $backer)
                <x-livewire.sponsoring.period-backer-item
                    :backer="$backer['backer']"
                    :contract="$backer['contract']"
                    wire:key="{{$backer['backer']->id}}"
                    :hasEditPermission="$hasEditPermission"/>
            @empty
                <div class="text-gray-600 text-center">-- {{__("no backers")}} --</div>
            @endforelse
        </div>
        @if(!empty($backerList["disabled"]))
            <div class="font-bold bg-gray-700 text-white py-2 px-4 mt-2">{{__("disabled")}}</div>
            <div class="divide-y divide-black border border-gray-700">
                @foreach($backerList["disabled"] as $backer)
                    <x-livewire.sponsoring.period-backer-item
                        :backer="$backer['backer']"
                        :contract="$backer['contract']"
                        wire:key="{{$backer['backer']->id}}"
                        :hasEditPermission="$hasEditPermission"/>
                @endforeach
            </div>
        @endif
        @if(!empty($backerList["closed"]))
            <div class="font-bold bg-gray-700 text-white py-2 px-4 mt-2">{{__("closed")}}</div>
            <div class="divide-y divide-black border border-gray-700">
                @foreach($backerList["closed"] as $backer)
                    <x-livewire.sponsoring.period-backer-item
                        :backer="$backer['backer']"
                        :contract="$backer['contract']"
                        wire:key="{{$backer['backer']->id}}"
                        :hasEditPermission="$hasEditPermission"/>
                @endforeach
            </div>
        @endif
    </div>

    <div class="flex flex-wrap gap-3 justify-around bg-white shadow-sm sm:rounded-lg mt-5 p-5">
        <div>
            <span>{{__("Created contracts")}}:</span>
            <span>{{$period->contracts()->count()}}</span>
        </div>
        <div>
            <span>{{__("member assigned")}}:</span>
            <span>{{$period->contracts()->has("member")->count()}}</span>
        </div>
        <div>
            <span>{{__("Refused")}}:</span>
            <span>{{$period->contracts()->whereNotNull("refused")->count()}}</span>
        </div>
        <div>
            <span>{{__("Package selected")}}:</span>
            <span>{{$period->contracts()->has("package")->count()}}</span>
            <span>({{\App\Facade\Currency::formatPrice(
    $period->contracts()->join("sponsor_packages",
    "sponsor_packages.id", "=", "sponsor_contracts.package_id")->sum("price"))}})</span>
        </div>
        <div>
            <span>{{__("Paid")}}:</span>
            <span>{{$period->contracts()->whereNotNull("paid")->count()}}</span>
            <span>({{\App\Facade\Currency::formatPrice(
    $period->contracts()->whereNotNull("paid")->join("sponsor_packages",
    "sponsor_packages.id", "=", "sponsor_contracts.package_id")->sum("price"))}})</span>
        </div>
    </div>
</div>
