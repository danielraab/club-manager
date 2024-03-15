<x-slot name="headline">
    <div class="flex gap-3 items-center">
        <a href="{{route("news.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Edit news") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex flex-wrap gap-2 items-center justify-between">
            <div class="flex flex-wrap gap-2 justify-start w-full sm:w-auto">
                <button type="button"
                        x-data="{ clickCnt: 0, onClick() {
                            if(this.clickCnt > 0) {
                                $wire.deleteNews();
                            } else {
                                this.clickCnt++;
                                $el.innerHTML = 'Are you sure?';
                            }
                        }}"
                        x-on:click="onClick()" title="Delete this news"
                        class="btn-danger">{{ __('Delete news') }}</button>
                @if($newsForm->display_until > now() && $newsForm->enabled && !$newsForm->logged_in_only)
                    <button type="button"
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
                            class="btn-secondary">{{ __('Force web push') }}</button>
                @endif
            </div>
            <div class="flex flex-wrap gap-2 justify-end w-full sm:w-auto">
                <button type="button" class="btn-info"
                        wire:click="saveNewsCopy"
                        title="Save copy of the news">{{ __('Save copy') }}</button>
                <button type="button" class="btn-primary" wire:click="saveNews"
                        title="Save current changes">{{ __('Save') }}</button>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.news.news-content/>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.news.news-settings :newsForm="$newsForm"/>
        </div>
    </div>
</div>
