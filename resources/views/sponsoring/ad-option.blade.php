@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_EDIT_PERMISSION);
    /** @var $adOption \App\Models\Sponsoring\AdOption */
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <a href="{{route("sponsoring.index")}}">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </a>
                <span>{{ __('Ad Option') }}</span>
            </div>
            @if($hasEditPermission)
                <div>
{{--                    <x-button-link class="btn-success"--}}
{{--                                   href="{{route('sponsoring.backer.create')}}"--}}
{{--                                   title="Create a new backer">{{__("New backer")}}</x-button-link>--}}
                </div>
            @endif
        </div>
    </x-slot>

    <div class="bg-white shadow-sm sm:rounded-lg p-4">
        <div class="gird grid-cols-2">
        @foreach(\App\Models\Sponsoring\AdOption::allActive()->get() as $adOption)
            <div class="border bg-amber-300 p-2 rounded-md">
                    <span class="font-bold">{{$adOption->title}}</span>
                @if($adOption->description)
                    <span>{{$adOption->description}}</span>
                @endif
                    <span class="block">{{$adOption->price}}</span>
            </div>
        @endforeach
        </div>
        @php($disabledList = \App\Models\Sponsoring\AdOption::query()->where("enabled", false)->get())
        @if($disabledList->isNotEmpty())
            <h3 class="font-bold py-5">{{__("Disabled")}}</h3>

            @foreach($disabledList as $backer)
            @endforeach
        @endif
    </div>
</x-backend-layout>
