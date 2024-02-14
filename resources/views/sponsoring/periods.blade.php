@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_EDIT_PERMISSION);
    /** @var $period \App\Models\Sponsoring\Period */
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <a href="{{route("sponsoring.index")}}">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </a>
                <span>{{ __('Period') }}</span>
            </div>
            @if($hasEditPermission)
                <div>
                    <x-button-link class="btn-success"
                                   href="{{route('sponsoring.period.create')}}"
                                   title="Create a new period">{{__("New period")}}</x-button-link>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="bg-white shadow-sm sm:rounded-lg p-4">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-2">
            @foreach(\App\Models\Sponsoring\Period::query()->orderBy("start", 'desc')->get() as $period)
                <x-sponsoring.period-item :period="$period" :hasEditPermission="$hasEditPermission"/>
            @endforeach
        </div>
    </div>
</x-backend-layout>
