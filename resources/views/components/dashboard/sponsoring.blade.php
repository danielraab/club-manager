@php
    /** @var \App\Models\Sponsoring\Period $period */
    $hasShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_SHOW_PERMISSION) ?? false;
@endphp
@if($hasShowPermission)
    <div class="flex flex-col mb-3">
        @php($periodList = \App\Models\Sponsoring\Period::query()->where('end','>',now()))
        <div class="bg-white shadow-sm sm:rounded-lg p-4 text-center">
        @if($periodList->count())
            <header class="font-bold mb-3">{{__('Active and upcoming sponsor periods')}}</header>
            <ul class="grid text-sm gap-2">
                @foreach($periodList->get() as $period)
                    <li class="grow bg-cyan-700 p-2 rounded">{{$period->title}}</li>
                @endforeach
            </ul>
            @else
                <span class="text-gray-500">{{__('no sponsor periods to show')}}</span>
            @endif
        </div>
    </div>
@endif
