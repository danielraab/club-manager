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
        <x-button-dropdown.dropdown class=" inline">
            <x-slot name="mainButton">
                <x-button-dropdown.mainButton type="button" class="btn-success" wire:click="saveNews"
                        title="Create new news" iconClass="fa-solid fa-plus">{{ __('Create') }}
                </x-button-dropdown.mainButton>
            </x-slot>
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
