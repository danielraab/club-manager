@props(["iconClass" => ""])
<button type="button" {{$attributes->merge(['class'=>'flex justify-start items-center py-2 text-xs px-4'])}}>
    @if($iconClass)
        <i class="w-6 text-center mr-2 {{$iconClass}}"></i>
    @endif
    {{$slot}}
</button>
