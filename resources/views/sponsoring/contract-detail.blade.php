@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_EDIT_PERMISSION);
    /** @var $contract \App\Models\Sponsoring\Contract */
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <a href="{{url()->previous()}}">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </a>
                <span class="text-gray-500">{{ __('Period details') }}:</span>
                <span>{{$contract->period()->first()->title}}</span>
            </div>
            @if($hasEditPermission)
                <div>
                    <x-button-link class="btn-edit"
                                   href="{{route('sponsoring.contract.edit', $contract->id)}}"
                                   title="Edit this contract">{{__("Edit contract")}}</x-button-link>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="flex justify-center">

        <div class="bg-white shadow-sm sm:rounded-lg p-4 w-full max-w-screen-sm">
            todo
        </div>
    </div>
</x-backend-layout>
