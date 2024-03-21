<x-slot name="headline">
    <div class="flex gap-3 items-center">
        <a href="{{route("news.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Create new news") }}
    </div>
</x-slot>

<div x-init="$store.notificationMessages
            .addNotificationMessages(
            JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex flex-row-reverse">
        <x-button-dropdown class=" inline">
            <x-slot name="mainButton">
                <button type="button" class="btn-primary p-2 text-xs" wire:click="saveNews"
                        title="Create new news"><i class="fa-solid fa-floppy-disk mr-2"></i>{{ __('Save') }}
                </button>
            </x-slot>
        </x-button-dropdown>
    </div>


    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.news.news-content/>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.news.news-settings/>
        </div>
    </div>

</div>
