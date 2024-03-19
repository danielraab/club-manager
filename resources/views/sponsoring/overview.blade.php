@php
    $hasShowPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_SHOW_PERMISSION);
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_EDIT_PERMISSION);
    /** @var $period \App\Models\Sponsoring\Period */
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <span>{{ __('Sponsoring') }}</span>
    </x-slot>
    @if($hasEditPermission)
        <x-slot name="headerBtn">
            <a class="btn btn-create gap-2"
               href="{{route('sponsoring.period.create')}}"
               title="Create a new period">
                <i class="fa-solid fa-plus"></i>
                <span>{{__("New period")}}</span>
            </a>
        </x-slot>
    @endif

    <div class="bg-white shadow-sm sm:rounded-lg p-4">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-2">
            @forelse(\App\Models\Sponsoring\Period::query()->orderBy("start", 'desc')->get() as $period)
                <x-sponsoring.period-item :period="$period" :hasShowPermission="$hasShowPermission"
                                          :hasEditPermission="$hasEditPermission"/>
            @empty
                <div class="text-gray-600 text-center col-span-full">-- {{__("no periods")}} --</div>
            @endforelse
        </div>
    </div>
</x-backend-layout>
