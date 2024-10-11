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
        <x-button-dropdown.dropdown>
            <x-slot name="mainButton">
                <x-button-dropdown.mainButton class="btn-success" wire:click="saveNews"
                        title="Save current changes" iconClass="fa-solid fa-floppy-disk mr-2">{{ __('Save') }}
                </x-button-dropdown.mainButton>
            </x-slot>

            <x-button-dropdown.button class="btn-success" wire:click="saveNewsCopy"
                    title="Save copy of the news" iconClass="fa-solid fa-copy">
                {{ __('Save copy') }}</x-button-dropdown.button>
            @if($newsForm->display_until > now() && $newsForm->enabled && !$newsForm->logged_in_only)
                <x-button-dropdown.button class="btn-info"
                        wire:confirm="{{__('Are you sure you want to send a web push to all subscribers?')}}"
                        wire:click="forceWebPush"
                        title="Force a web push to all subscribes (with the updated data)."
                        iconClass="fa-solid fa-bell">
                    {{ __('Force web push') }}</x-button-dropdown.button>
            @endif
            <x-button-dropdown.button class="btn-danger"
                    wire:confirm="{{__('Are you sure you want to delete this news?')}}"
                    wire:click="deleteNews" title="Delete this news"
                    iconClass="fa-solid fa-trash">
                {{ __('Delete news') }}</x-button-dropdown.button>
        </x-button-dropdown.dropdown>
    </div>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            @include('livewire.news.partials.news-content')
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            @include('livewire.news.partials.news-settings')
        </div>
    </div>
</div>
