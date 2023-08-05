<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Edit news") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex flex-wrap gap-2 items-center justify-between">
            <div class="flex flex-wrap gap-2 justify-start w-full sm:w-auto">
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
                @if($display_until > now() && $news->enabled && $news->logged_in_only)
                    <x-default-button
                        x-data="{ clickCnt: 0, disabled: false, onClick() {
                            if(this.clickCnt == 1) {
                                $wire.forceWebPush();
                                this.disabled = true;
                            } else {
                                this.clickCnt++;
                                $el.innerHTML = 'Are you sure?';
                            }
                        }}"
                        x-on:click="onClick()" title="Force a web push to all subscribes (with the updated data)."
                        x-bind:disabled="disabled"
                        class="btn-secondary">{{ __('Force web push') }}</x-default-button>
                @endif
            </div>
            <div class="flex flex-wrap gap-2 justify-end w-full sm:w-auto">
                <x-default-button class="bg-cyan-700 hover:bg-cyan-500 focus:bg-cyan-500 text-white"
                                  wire:click="saveNewsCopy"
                                  title="Save copy of the news">{{ __('Save copy') }}</x-default-button>
                <x-default-button class="btn-primary" wire:click="saveNews"
                                  title="Save current changes">{{ __('Save') }}</x-default-button>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.news.news-content/>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.news.news-settings :news="$news"/>
        </div>
    </div>
</div>
