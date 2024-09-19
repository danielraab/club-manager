@php
    /**
     * @var $backer \App\Models\Sponsoring\Backer
     * @var $period \App\Models\Sponsoring\Period
     * @var $contract \App\Models\Sponsoring\Contract|null
     */
    $green = "text-green-700";
    $yellow = "text-yellow-600";
    $red = "text-red-600";
    $gray = "text-gray-400";
@endphp
<div class="flex flex-col sm:flex-row gap-3 items-center sm:justify-between px-5 py-2">
    <div class="text-center">{{$backer->name}} <span class="text-gray-700">- {{$backer->zip}} {{$backer->city}}</span></div>
    <div class="flex">
        <div class="flex items-center gap-3">
            @if($contract !== null)
                <a class="flex items-center"
                   href="{{route('sponsoring.contract.detail', $contract->id)}}"
                title="{{__("show contract details")}}">
                    <i class="fa-solid fa-circle-info text-cyan-900"></i>
                </a>
                @if($contract->member)
                    <i class="fa-solid fa-user {{$green}}" x-tippy title="{{$contract->member->getFullName()}}"></i>
                @else
                    <i class="fa-solid fa-user {{$red}}"></i>
                @endif
                @if($contract->refused)
                    <i class="fa-solid fa-ban {{$red}}" x-tippy title="{{$contract->refused->formatDateOnly(true)}}"></i>
                @else
                    <i class="fa-solid fa-ban {{$gray}}"></i>
                @endif
                @if($contract->package)
                    <i class="fa-solid fa-cube {{$green}}"
                       x-tippy title="{{$contract->package->title}} ({{\App\Facade\Currency::formatPrice($contract->package->price)}})"></i>
                @else
                    <i class="fa-solid fa-cube {{$gray}}"></i>
                @endif
                @php($hasContractFileCss = $contract->uploadedFile()->count() > 0)
                @if($hasContractFileCss)
                    <i class="fa-solid fa-file-contract {{$green}}"
                       x-tippy title="{{__('Contract already uploaded')}}"></i>
                @elseif($contract->contract_received)
                    <i class="fa-solid fa-file-contract {{$yellow}}"
                       x-tippy title="{{$contract->contract_received->formatDateOnly(true)}}"></i>
                @else
                    <i class="fa-solid fa-file-contract {{$contract->package ? $red : $gray}}"></i>
                @endif
                @php($hasAdDataFilesCss = $backer->uploadedFiles()->count() > 0)
                @if($contract->ad_data_received)
                    <i class="fa-regular fa-image {{$hasAdDataFilesCss ? $green : $yellow}}"
                       x-tippy title="{{$contract->ad_data_received->formatDateOnly(true)}}"></i>
                @elseif($hasAdDataFilesCss)
                    <i class="fa-regular fa-image text-blue-700"
                       x-tippy title="{{__('No ad data files received, but old data is available.')}}"></i>
                @else
                    <i class="fa-regular fa-image {{$contract->package ? $red : $gray}}"></i>
                @endif
                @if($contract->paid)
                    <i class="fa-solid fa-money-bill-wave {{$green}}"
                       x-tippy title="{{$contract->paid->formatDateOnly(true)}}"></i>
                @else
                    <i class="fa-solid fa-money-bill-wave {{$contract->package ? $red : $gray}}"></i>
                @endif
                @if($hasEditPermission)
                    <a class="btn btn-primary w-8 justify-center"
                       href="{{route('sponsoring.contract.edit', $contract->id)}}"
                       x-tippy title="edit contract">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                @endif
            @else
                <i class="fa-solid fa-user {{$gray}}"></i>
                <i class="fa-solid fa-ban {{$gray}}"></i>
                <i class="fa-solid fa-cube {{$gray}}"></i>
                <i class="fa-solid fa-file-contract {{$gray}}"></i>
                <i class="fa-regular fa-image {{$gray}}"></i>
                <i class="fa-solid fa-money-bill-wave {{$gray}}"></i>
                @if($hasEditPermission)
                    <button type="button" class="btn btn-danger w-8 justify-center"
                                      wire:click="createContract({{$backer->id}})">
                        <i class="fa-solid fa-file-contract"></i>
                    </button>
                @endif
            @endif
        </div>
    </div>
</div>
