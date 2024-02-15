@php
    /** @var $period \App\Models\Sponsoring\Period */
    /** @var $backer \App\Models\Sponsoring\Backer */
@endphp
<x-slot name="headline">
    <div class="flex items-center gap-2">
        <a href="{{route("sponsoring.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        <span class="text-gray-500">{{__("Period")}}:</span> {{$period->title}}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex justify-between items-center">
        @if($period->end > now())
            <x-default-button
                x-data="{ clickCnt: 0, onClick() {
                if(this.clickCnt > 0) {
                    $wire.generateContracts();
                } else {
                    this.clickCnt++;
                    $el.innerHTML = 'Are you sure?';
                }
            }}"
                x-on:click="onClick()" title="Generate a contract for every backer."
                class="btn-secondary">{{ __('Generate contracts') }}</x-default-button>
        @endif
    </div>

    <div class="bg-white shadow-sm sm:rounded-lg p-5">
        @foreach(\App\Models\Sponsoring\Backer::allActive()->get() as $backer)
            <div>
                {{$backer->name}}
            </div>
        @endforeach
    </div>
</div>
