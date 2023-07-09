<div class="flex flex-col gap-2">

    @forelse($newsList as $news)

        <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
            <p class="font-bold">{{$news->title}}</p>
            <p class="text-sm">{!! $news->content !!}</p>
        </div>

    @empty
        <div class="text-center text-gray-500">
            <p>{{__("No news to display.")}}</p>
            <p>{{__("Check again later.")}}</p>
        </div>
    @endforelse
</div>
