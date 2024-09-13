@props(["iconClass" => ""])
<a {{$attributes->merge(['class'=>'p-2 text-xs'])}}>
    @if($iconClass)
        <i class="mr-2 {{$iconClass}}"></i>
    @endif
    {{$slot}}
</a>
