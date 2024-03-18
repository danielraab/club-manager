@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\News::NEWS_EDIT_PERMISSION);
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <span>{{ __('News Overview') }}</span>
        </div>
    </x-slot>
    @if($hasEditPermission)
        <x-slot name="headerBtn">
            <a href="{{route('news.create')}}" class="btn btn-create"
               title="Create new news">
                <i class="fa-solid fa-plus"></i>
            </a>
        </x-slot>
    @endif

    <div class="flex justify-center mb-3">
        {!! $newsList->links('vendor.pagination.paginator') !!}
    </div>

    <div class="flex flex-col gap-3 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
        @forelse($newsList as $news)
            <div
                class="max-w-full border border-gray-400 px-4 py-2 flex flex-col justify-between leading-normal">
                <div class="mb-5">
                    <div class="text-gray-900 font-bold text-xl mb-2 flex items-top justify-between">
                        <span>{{ $news->title }}</span>
                        <div class="flex items-center ml-3">
                            @if($news->logged_in_only)
                                <i class="fa-solid fa-arrow-right-to-bracket text-sm text-gray-600 mr-2"
                                   title="{{__("Visible only for logged in users")}}"></i>
                            @endif
                            @if(!$news->enabled)
                                <x-dot class="bg-rose-400" title="News disabled"/>
                            @elseif($news->display_until < now())
                                <x-dot class="bg-gray-400" title="News retired"/>
                            @else
                                <x-dot class="bg-green-500" title="News active"/>
                            @endif
                        </div>
                    </div>
                    <p class="text-gray-700 text-base">
                        {{ strlen($news->content) > 200 ? substr($news->content, 0,150) . " ..." : $news->content }}
                    </p>
                </div>
                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        <p class="text-gray-900 leading-none">
                            @if($news->creator)
                                <span title="{{__("Creator")}}"><i class="fa-regular fa-square-plus"></i> {{$news->creator->name}}</span>
                            @endif
                            @if($news->lastUpdater)
                                <span title="{{__("Last updater")}}"><i class="fa-solid fa-pencil ml-2"></i> {{ $news->lastUpdater->name }}</span>
                            @endif
                        </p>
                        <p class="text-gray-600">
                            <span title="{{__("Last updated")}}"><i class="fa-regular fa-pen-to-square"></i> {{$news->updated_at?->formatDateOnly()}}</span>
                            @if($news->display_until)
                                <span title="{{__("Displayed on dashboard until")}}"><i
                                        class="fa-regular fa-clock ml-2"></i> {{$news->display_until?->formatDateOnly()}}</span>
                            @endif
                        </p>
                    </div>
                    @if($hasEditPermission)
                        <a href="{{route('news.edit', $news->id)}}" title="Edit this news"
                           class="btn btn-edit">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <span>No news to show.</span>
        @endforelse
    </div>
    <div class="flex justify-center mt-3">
        {!! $newsList->links('vendor.pagination.paginator') !!}
    </div>
</x-backend-layout>
