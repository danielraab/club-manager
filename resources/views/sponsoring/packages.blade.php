@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_EDIT_PERMISSION);
    /** @var $package \App\Models\Sponsoring\Package */
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex items-center gap-2">
            <a href="{{route("sponsoring.index")}}">
                <i class="fa-solid fa-arrow-left-long"></i>
            </a>
            <span>{{ __('Packages') }}</span>
        </div>
    </x-slot>
    @if($hasEditPermission)
        <x-slot name="headerBtn">
            <a class="btn btn-create max-sm:text-lg gap-2"
               href="{{route('sponsoring.package.create')}}"
               title="Create a new package">
                <i class="fa-solid fa-plus"></i>
                <span class="max-sm:hidden">{{__("New package")}}</span>
            </a>
        </x-slot>
    @endif

    <div class="bg-white shadow-sm sm:rounded-lg p-4">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-2">
            @forelse(\App\Models\Sponsoring\Package::allActive()->with(["adOptions", "periods"])->get() as $package)
                <x-sponsoring.package-item :package="$package" :hasEditPermission="$hasEditPermission"/>
            @empty
                <div class="text-gray-600 text-center">-- {{__("no packages")}} --</div>
            @endforelse
        </div>

        @php($disabledList = \App\Models\Sponsoring\Package::query()->where("enabled", false)->get())
        @if($disabledList->isNotEmpty())
            <h3 class="font-bold py-5">{{__("Disabled")}}</h3>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-2">
                @foreach($disabledList as $package)
                    <x-sponsoring.package-item :package="$package" :hasEditPermission="$hasEditPermission"/>
                @endforeach
            </div>
        @endif
    </div>
</x-backend-layout>
