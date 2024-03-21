<div x-data="{open:false}" @click.outside="open = false" @close.stop="open = false">
    <div {{ $attributes->merge(['class' => 'flex items-center border rounded-md overflow-hidden divide-x hover:cursor-pointer']) }}>
        {{$mainButton}}
        @if(trim($slot))
            <div x-ref="openButton" x-on:click="open = !open" class="px-2 py-2 text-xs bg-gray-300 hover:bg-gray-400">
                <i class="fa-solid fa-caret-down"></i>
            </div>
        @endif
    </div>
    @if(trim($slot))
        <div x-show="open" x-cloak x-anchor.bottom-end="$refs.openButton" x-collapse
             class="flex flex-col bg-white rounded border overflow-hidden shadow-md z-50">{{$slot}}</div>
    @endif
</div>
