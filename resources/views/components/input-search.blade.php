<!-- This is an example component -->
<div class="relative mx-auto text-gray-600">
    <input
        {{$attributes->except("wire:click")->merge(['class' => "border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"])}}
        type="search" name="search" placeholder="Search">
    <button type="submit" class="absolute right-0 top-0 mt-2 mr-3" {{$attributes->only("wire:click")}}>
        <i class="fa-solid fa-magnifying-glass"></i>
    </button>
</div>
