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
    <x-livewire.loading/>
    @if($hasEditPermission && $period->end > now())
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex justify-between items-center">
            <div class="flex items-center gap-3 flex-wrap">
                <x-default-button
                    x-data="{ clickCnt: 0, onClick() {
                if(this.clickCnt > 0) {
                    $wire.generateAllContracts();
                } else {
                    this.clickCnt++;
                    $el.innerHTML = 'Are you sure?';
                }
            }}"
                    x-on:click="onClick()" title="Generate a contract for every backer."
                    class="btn-secondary">{{ __('Generate contracts') }}</x-default-button>
                @if(session()->has("createdMessage"))
                    <p class="text-gray-700"
                       x-init="setTimeout(()=> {$el.remove()}, 5000);">{{session()->pull("createdMessage")}}</p>
                @endif
            </div>

            <x-button-link href="{{route('sponsoring.period.edit', $period->id)}}" class="btn-primary" title="Edit this period">
                {{__("Edit period")}}
            </x-button-link>
        </div>
    @endif

    <div class="bg-white shadow-sm sm:rounded-lg p-5 divide-y divide-black">
        {{--   TODO sort reject at the end--}}
        @foreach(\App\Models\Sponsoring\Backer::allActive()->get() as $backer)
            <x-livewire.sponsoring.period-backer-item
                :backer="$backer"
                wire:key="{{$backer->id}}"
                :hasEditPermission="$hasEditPermission"/>
        @endforeach
    </div>
</div>
