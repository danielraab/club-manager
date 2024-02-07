@php
    $hasEditPermission = (bool) \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_EDIT_PERMISSION);
    /** @var $backer \App\Models\Sponsoring\Backer */
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <span>{{ __('Backer') }}</span>
            {{--            <div>--}}
            {{--                @if($hasShowPermission && $showBirthdayListConfig)--}}
            {{--                    <x-button-link class="btn-secondary"--}}
            {{--                                   href="{{route('member.birthdayList')}}"--}}
            {{--                                   title="Show list of member birthdays">{{ __('Birthday list') }}</x-button-link>--}}
            {{--                @endif--}}
            {{--                @if($hasImportPermission && $showMemberImportConfig)--}}
            {{--                    <x-button-link class="btn-info"--}}
            {{--                                   href="{{route('member.import')}}"--}}
            {{--                                   title="Import member list">{{__("Import members")}}</x-button-link>--}}
            {{--                @endif--}}
            {{--            </div>--}}
        </div>
    </x-slot>

    <div class="flex flex-col-reverse gap-4">
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            @foreach(\App\Models\Sponsoring\Backer::all() as $backer)
                <livewire:sponsoring.backer-overview-item :backer="$backer" wire:key="{{$backer->id}}"/>
            @endforeach
        </div>

    </div>
</x-backend-layout>
