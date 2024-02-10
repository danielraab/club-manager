@php
    /** @var $backer \App\Models\Sponsoring\Backer */
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <span>{{ __('Backer') }}</span>
            <div>
                <x-button-link class="btn-success"
                               href="{{route('sponsoring.backer.create')}}"
                               title="Create a new backer">{{__("New backer")}}</x-button-link>
            </div>
        </div>
    </x-slot>

    <div class="bg-white shadow-sm sm:rounded-lg p-4">
        @foreach(\App\Models\Sponsoring\Backer::allActive()->get() as $backer)
            <livewire:sponsoring.backer-overview-item :backer="$backer" wire:key="{{$backer->id}}"/>
        @endforeach

        @php($disabledList = \App\Models\Sponsoring\Backer::query()->where("enabled", false)->get())
        @if($disabledList->isNotEmpty())
            <h3 class="font-bold py-5">{{__("Disabled")}}</h3>

            @foreach($disabledList as $backer)
                <livewire:sponsoring.backer-overview-item :backer="$backer" wire:key="{{$backer->id}}"/>
            @endforeach
        @endif

        @php($closedList = \App\Models\Sponsoring\Backer::query()->whereNotNull("closed_at")->get())
        @if($closedList->isNotEmpty())
            <h3 class="font-bold py-5">{{__("Closed")}}</h3>

            @foreach($closedList as $backer)
                <livewire:sponsoring.backer-overview-item :backer="$backer" wire:key="{{$backer->id}}"/>
            @endforeach
        @endif

    </div>
</x-backend-layout>
