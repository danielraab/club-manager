@php($commonClasses = "inline-flex items-center p-2 hover:cursor-pointer text-xs")
@if($attributes->has('href'))
<a {{ $attributes->merge(['class' => "$commonClasses"]) }}>
    {{$slot}}
</a>
@else
<div {{ $attributes->merge(['class' => "$commonClasses"]) }}>
    {{$slot}}
</div>
@endif
