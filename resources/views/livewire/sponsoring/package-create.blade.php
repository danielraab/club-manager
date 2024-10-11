<x-slot name="headline">
    <div class="flex items-center gap-2">
        <a href="{{route("sponsoring.package.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Add new package") }}
    </div>
</x-slot>

<div x-init="$store.notificationMessages
            .addNotificationMessages(
            JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3 p-5 flex justify-end gap-2 items-center">
        <button type="button" class="btn btn-create" wire:click="savePackage"
                title="Create new package"><i class="fa-solid fa-plus mr-2"></i>{{ __('Save') }}</button>
    </div>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            @include('livewire.sponsoring.partials.package-content')
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            @include('livewire.sponsoring.partials.package-ad-option-selection')
        </div>
    </div>
</div>
