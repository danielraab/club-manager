<!-- This is an example component -->
<div class="relative text-gray-600">
    <x-input
        {{$attributes->except('wire:click')->merge(['class' => 'h-10 px-5 pr-16 text-sm'])}}
        type="search" name="search" placeholder="{{__('Search')}}"/>
    <button type="submit" class="absolute right-0 top-0 mt-2 mr-3" {{$attributes->only("wire:click")}}>
        <i class="fa-solid fa-magnifying-glass"></i>
    </button>
</div>
