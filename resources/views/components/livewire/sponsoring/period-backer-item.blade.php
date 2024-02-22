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
    $contract = $backer->contracts()->where("period_id", $this->period->id)->first();
@endphp
<div class="flex flex-col sm:flex-row gap-3 items-center sm:justify-between px-5 py-2">
    <div>{{$backer->name}} <span class="text-gray-700">- {{$backer->zip}} {{$backer->city}}</span></div>
    <div class="flex">
        <div class="flex items-center gap-3">
            @if($contract !== null)
                @if($contract->member_id)
                    <i class="fa-solid fa-user {{$green}}" title="{{$contract->member()->first()->getFullName()}}"></i>
                @else
                    <i class="fa-solid fa-user {{$red}}"></i>
                @endif
                @if($contract->refused)
                    <i class="fa-solid fa-ban {{$red}}" title="{{$contract->refused->formatDateOnly(true)}}"></i>
                @else
                    <i class="fa-solid fa-ban {{$gray}}"></i>
                @endif
                @if($contract->package_id)
                    <i class="fa-solid fa-cube {{$green}}" title="{{$contract->package()->first()->title}}"></i>
                @else
                    <i class="fa-solid fa-cube {{$gray}}"></i>
                @endif
                @if($contract->contract_received)
                    @php($hasContractFileCss = $contract->uploadedFile()->count() > 0)
                    <i class="fa-solid fa-file-contract {{$hasContractFileCss ? $green : $yellow}}" title="{{$contract->contract_received->formatDateOnly(true)}}"></i>
                @else
                    <i class="fa-solid fa-file-contract {{$gray}}"></i>
                @endif
                @if($contract->ad_data_received)
                        @php($hasAdDataFilesCss = $backer->uploadedFiles()->count() > 0)
                    <i class="fa-regular fa-image {{$hasAdDataFilesCss ? $green : $yellow}}" title="{{$contract->ad_data_received->formatDateOnly(true)}}"></i>
                @else
                    <i class="fa-regular fa-image {{$gray}}"></i>
                @endif
                @if($contract->paid)
                    <i class="fa-solid fa-money-bill-wave {{$green}}" title="{{$contract->paid->formatDateOnly(true)}}"></i>
                @else
                    <i class="fa-solid fa-money-bill-wave {{$gray}}"></i>
                @endif
                @if($hasEditPermission)
                    <x-button-link class="btn-primary w-8 justify-center"
                                   href="{{route('sponsoring.contract.edit', $contract->id)}}">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </x-button-link>
                @endif
            @else
                <i class="fa-solid fa-user {{$gray}}"></i>
                <i class="fa-solid fa-ban {{$gray}}"></i>
                <i class="fa-solid fa-cube {{$gray}}"></i>
                <i class="fa-solid fa-file-contract {{$gray}}"></i>
                <i class="fa-regular fa-image {{$gray}}"></i>
                <i class="fa-solid fa-money-bill-wave {{$gray}}"></i>
                @if($hasEditPermission)
                    <x-default-button class="btn-danger w-8 justify-center"
                                      wire:click="createContract({{$backer->id}})">
                        <i class="fa-solid fa-file-contract"></i>
                    </x-default-button>
                @endif
            @endif
        </div>
    </div>
</div>
