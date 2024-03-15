@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_EDIT_PERMISSION);
    /** @var $backer \App\Models\Sponsoring\Backer */
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <a href="{{route("sponsoring.index")}}">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </a>
                <span>{{ __('Backers') }}</span>
            </div>
            @if($hasEditPermission)
                <div>
                    <a class="btn-create"
                                   href="{{route('sponsoring.backer.create')}}"
                                   title="Create a new backer">{{__("New backer")}}</a>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="bg-white shadow-sm sm:rounded-lg p-4">
        @php($backerList = \App\Models\Sponsoring\Backer::allActive()->get())
        @if($backerList->isNotEmpty())
            @foreach($backerList as $backer)
                <x-sponsoring.backer-overview-item :backer="$backer"
                                                          :hasEditPermission="$hasEditPermission"/>
            @endforeach
            <div class="p-3">{{$backerList->count()}} {{__("backers")}}</div>
        @else
            <div class="text-gray-600 text-center">-- {{__("no backers")}} --</div>
        @endif

        @php($disabledList = \App\Models\Sponsoring\Backer::query()->where("enabled", false)->get())
        @if($disabledList->isNotEmpty())
            <h3 class="font-bold py-5">{{__("Disabled")}}</h3>

            @foreach($disabledList as $backer)
                <x-sponsoring.backer-overview-item :backer="$backer"
                                                          :hasEditPermission="$hasEditPermission"/>
            @endforeach
        @endif

        @php($closedList = \App\Models\Sponsoring\Backer::query()->whereNotNull("closed_at")->get())
        @if($closedList->isNotEmpty())
            <h3 class="font-bold py-5">{{__("Closed")}}</h3>

            @foreach($closedList as $backer)
                <x-sponsoring.backer-overview-item :backer="$backer"
                                                          :hasEditPermission="$hasEditPermission"/>
            @endforeach
        @endif
    </div>
</x-backend-layout>
