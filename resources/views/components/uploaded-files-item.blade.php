@php
    /** @var $file \App\Models\UploadedFile */
    /** @var $storer \Illuminate\Database\Eloquent\Model|null */
    $type = '';
    $typeLink = null;
    $storer = $file->storer;
    $storerPossibleSoftDelete = $storer && method_exists($storer, 'trashed');
    if($storer === null) $type = __('no storer');
    else {
        list($type, $typeLink) = match(get_class($storer)){
            \App\Models\Sponsoring\Backer::class => [__('Backer'), route('sponsoring.backer.edit', $storer->id)],
            \App\Models\Sponsoring\Contract::class => [__('Contract'), route('sponsoring.contract.edit', $storer->id)],
            \App\Models\Sponsoring\Period::class => [__('Period'), route('sponsoring.period.edit', $storer->id)],
            default => [__('unknown type'), null]
        };
    }
@endphp
<li class="ml-5">
    <span class="@if($storerPossibleSoftDelete && $storer->trashed()) line-through text-red-700 @endif
                    @if(!$storer) font-bold @endif">
        @if($typeLink)
            <a class="underline" href="{{$typeLink}}">{{$type}}</a>
        @else
        {{$type}}
        @endif
    </span> -
    @if($file->forcePublic || $file->isPublicStored()) <i class="fa-solid fa-globe"></i> @endif

    @if(!\Illuminate\Support\Facades\Storage::exists($file->path))
        <span class="text-red-700 @if($file->trashed()) line-through @endif "
            title="{{__("File does not exit on the server.")}}">{{$file->name}}</span>
    @else
        <span class="text-gray-500 @if($file->trashed()) line-through @endif ">
            <a class="underline" href="{{$file->getUrl()}}">{{$file->name}}</a>
        </span>
    @endif

    @if($file->uploader)
    <span class="text-gray-500 text-xs">({{$file->uploader->name}})</span>
    @endif
</li>
