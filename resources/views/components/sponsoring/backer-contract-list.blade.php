
@php
    /** @var \App\Models\Sponsoring\Backer $backer */
    /** @var \App\Models\Sponsoring\Contract $contract */
    $contracts = $backer?->contracts()->get();
@endphp
@if($contracts && $contracts->isNotEmpty())
    <div class="mt-3">
        <h3 class="font-semibold">
            <i class="fa-solid fa-file-contract"></i> {{__('Contracts')}}
        </h3>
        <ul class="list-disc ml-5 pl-5">
            @foreach($contracts as $contract)
                <li class="text-sm">{{$contract->period->title}} - {{$contract->package?->title ?: __('no package')}} - {{$contract->member?->getFullName()}}</li>
            @endforeach
        </ul>
    </div>
@endif
