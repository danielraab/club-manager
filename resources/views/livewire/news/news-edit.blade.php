<x-slot name="headline">
    <div class="flex gap-3 items-center">
        <a href="{{route("news.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Edit news") }}
    </div>
</x-slot>

<div x-init="$store.notificationMessages
            .addNotificationMessages(
            JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))">
    <div class="flex justify-end bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3 p-5">
        <x-button-dropdown class=" inline">
            <x-slot name="mainButton">
                <button type="button" class="btn-success p-2 text-xs" wire:click="saveNews"
                        title="Save current changes"><i class="fa-solid fa-floppy-disk mr-2"></i>{{ __('Save') }}
                </button>
            </x-slot>

            <button type="button" class="btn-success inline-flex gap-2 p-2 text-xs" wire:click="saveNewsCopy"
                    title="Save copy of the news"><i class="fa-solid fa-copy"></i> {{ __('Save copy') }}</button>
            @if($newsForm->display_until > now() && $newsForm->enabled && !$newsForm->logged_in_only)
                <button type="button" class="text-xs p-2 btn-info inline-flex gap-2"
                        wire:confirm="{{__('Are you sure you want to send a web push to all subscribers?')}}"
                        wire:click="forceWebPush"
                        title="Force a web push to all subscribes (with the updated data).">
                    <i class="fa-solid fa-bell"></i> {{ __('Force web push') }}</button>
            @endif
            <button type="button" class="text-xs p-2 btn-danger inline-flex gap-2"
                    wire:confirm="{{__('Are you sure you want to delete this news?')}}"
                    wire:click="deleteNews" title="Delete this news"
            ><i class="fa-solid fa-trash"></i> {{ __('Delete news') }}</button>
        </x-button-dropdown>
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
