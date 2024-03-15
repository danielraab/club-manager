<div x-data="{open:false}" @click.outside="open = false" @close.stop="open = false">
    <div {{ $attributes->merge(['class' => 'flex items-center border rounded-md divide-x hover:cursor-pointer']) }}>
        {{$mainButton}}
        <div x-ref="openButton" x-on:click="open = !open" class="px-2 py-2 text-xs">
            <i class="fa-solid fa-caret-down"></i></div>
    </div>
    <div x-show="open" x-cloak x-anchor.bottom-end="$refs.openButton" x-collapse
         class="bg-white rounded border overflow-hidden shadow-md z-50">{{$slot}}</div>
</div>
