@php
    /** @var \App\Models\Sponsoring\Period $period */
    $hasShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_SHOW_PERMISSION) ?? false;
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_EDIT_PERMISSION) ?? false;
@endphp
@if($hasShowPermission)
    <div class="flex-1 flex flex-col mb-3">
        @php($periodList = \App\Models\Sponsoring\Period::query()->where('end','>',now()))
        <div class="bg-white shadow-sm sm:rounded-lg p-4 text-center">
        @if($periodList->count())
            <header class="font-bold mb-3">{{__('Active and upcoming sponsor periods')}}</header>
            <ul class="grid text-sm gap-2 text-white">
                @foreach($periodList->get() as $period)
                    <li class="flex flex-wrap bg-cyan-700 p-1 rounded items-center justify-center gap-4">
                        <span>
                            {{$period->title}}
                        </span>
                        @if($hasEditPermission)
                            <div class="flex justify-center gap-4">
                                <a href="{{route('sponsoring.period.adOption.overview', $period->id)}}" title="{{__("Show ad options overview for this periods")}}">
                                    <i class="fa-solid fa-images"></i>
                                </a>
                                <a href="{{route('sponsoring.period.backer.overview', $period->id)}}" title="{{__("Show period backer overview")}}">
                                    <i class="fa-solid fa-table-list"></i>
                                </a>
                                @if($hasEditPermission)
                                    <a href="{{route('sponsoring.period.edit', $period->id)}}" title="{{__("Edit this period")}}">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
            @else
                <span class="text-gray-500">{{__('no sponsor periods to show')}}</span>
            @endif
        </div>
    </div>
@endif
