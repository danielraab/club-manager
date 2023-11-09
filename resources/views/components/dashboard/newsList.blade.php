@php
    /** @var \App\Models\News $news */
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\News::NEWS_EDIT_PERMISSION) ?? false;
@endphp
<div class="flex flex-col gap-2">

    @forelse($newsList as $news)

        <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
            <p class="font-bold">{{$news->title}}</p>
            <p class="text-sm">{!! $news->content !!}</p>

            <div class="flex justify-end items-center gap-1">
                @if($news->logged_in_only)
                    <i class="fa-solid fa-arrow-right-to-bracket text-sm text-gray-600 mr-2"
                       title="{{__("Visible only for logged in users")}}"></i>
                @endif
                @if($hasEditPermission)
                    <a href="{{route('news.edit', $news->id)}}" title="Edit this news">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                @endif
            </div>
        </div>

    @empty
        <div class="text-center text-gray-500">
            <p>{{__("No news to display.")}}</p>
            <p>{{__("Check again later.")}}</p>
        </div>
    @endforelse
</div>
