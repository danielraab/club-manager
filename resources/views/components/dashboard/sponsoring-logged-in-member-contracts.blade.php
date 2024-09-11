@php
    /** @var \App\Models\Sponsoring\Contract $contract */
    /** @var \Illuminate\Database\Eloquent\Collection|null $contracts */
    /** @var \App\Models\User $user */
        $user = auth()->user();
        $contracts = $user?->getMember()?->contracts()->whereIn('period_id', \App\Models\Sponsoring\Period::query()->where('end', '>', now())->get('id'))->get();
@endphp
@if($contracts && $contracts->isNotEmpty())
    <div class="flex-1 flex flex-col mb-3 bg-white shadow-sm sm:rounded-lg p-4 text-center">
        <header class="font-bold mb-3">{{__('Your current sponsoring contracts')}}</header>
        <ul class="grid text-sm gap-2 text-white">
            @foreach($contracts as $contract)
                <li class="flex flex-wrap bg-indigo-800 p-1 rounded items-center justify-center gap-2">
                    <span>
                        {{$contract->backer->name}} <span class="text-gray-200 text-xs">({{$contract->period->title}})</span>
                    </span>
                    @if($contract->package)
                    <span>
                        <i class="fa-solid fa-cube"></i> {{$contract->package->title}}
                    </span>
                    @endif
                    @if($contract->refused)
                        <i class="fa-solid fa-ban text-red-600" title="{{$contract->refused->formatDateOnly(true)}}"></i>
                    @endif
                    @if($contract->ad_data_received)
                        <i class="fa-regular fa-image" title="{{$contract->ad_data_received->formatDateOnly(true)}}"></i>
                    @endif
                    @if($contract->contract_received)
                        <i class="fa-solid fa-file-contract" title="{{$contract->contract_received->formatDateOnly(true)}}"></i>
                    @endif
                    @if($contract->paid)
                        <i class="fa-solid fa-money-bill-wave text-green-600" title="{{$contract->paid->formatDateOnly(true)}}"></i>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endif
