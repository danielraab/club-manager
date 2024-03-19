@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_EDIT_PERMISSION);
    /** @var $adOption \App\Models\Sponsoring\AdOption */
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex items-center gap-2">
            <a href="{{route("sponsoring.index")}}">
                <i class="fa-solid fa-arrow-left-long"></i>
            </a>
            <span>{{ __('Ad Options') }}</span>
        </div>
    </x-slot>
    @if($hasEditPermission)
        <x-slot name="headerBtn">
            <div>
                <a class="btn btn-create max-sm:text-lg gap-2"
                   href="{{route('sponsoring.ad-option.create')}}"
                   title="Create a new ad option">
                    <i class="fa-solid fa-plus"></i>
                    <span class="max-sm:hidden">{{__("New ad option")}}</span>
                </a>
            </div>
        </x-slot>
    @endif

    <div class="bg-white shadow-sm sm:rounded-lg p-4">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
            @forelse(\App\Models\Sponsoring\AdOption::allActive()->get() as $adOption)
                <x-sponsoring.ad-option-item :adOption="$adOption" :hasEditPermission="$hasEditPermission"/>
            @empty
                <div class="text-gray-600 text-center col-span-full">-- {{__("no backers")}} --</div>
            @endforelse
        </div>
        @php($disabledList = \App\Models\Sponsoring\AdOption::query()->where("enabled", false)->get())
        @if($disabledList->isNotEmpty())
            <h3 class="font-bold py-5">{{__("Disabled")}}</h3>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                @foreach($disabledList as $adOption)
                    <x-sponsoring.ad-option-item :adOption="$adOption" :hasEditPermission="$hasEditPermission"/>
                @endforeach
            </div>
        @endif
    </div>
</x-backend-layout>
