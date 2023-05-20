<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Edit news") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex items-center justify-between">
            <x-default-button
                x-data="{ clickCnt: 0, onClick() {
                if(this.clickCnt > 0) {
                    $wire.deleteNews();
                } else {
                    this.clickCnt++;
                    $el.innerHTML = 'Are you sure?';
                }
            }}"
                x-on:click="onClick()" title="Delete this news"
                class="btn-danger">{{ __('Delete news') }}</x-default-button>
            <x-default-button class="btn-primary" wire:click="saveNews"
                              title="Save current changes">{{ __('Save') }}</x-default-button>
        </div>
    </div>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.news.news-content />
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.news.news-settings :news="$news"/>
        </div>
    </div>
</div>
