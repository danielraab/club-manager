@php
    /** @var \App\Models\UploadedFile $uploadedFile */
@endphp
<x-slot name="headline">
    <div class="flex gap-3 items-center">
        <a href="{{route("uploaded-file.list")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Edit uploaded file") }}
    </div>
</x-slot>

<div x-init="$store.notificationMessages
            .addNotificationMessages(
            JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))">
    <div class="flex justify-end bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3 p-5">
        <x-button-dropdown.dropdown>
            <x-slot name="mainButton">
                <x-button-dropdown.mainButton class="btn-success" wire:click="saveUploadedFile"
                        title="Save current changes" iconClass="fa-solid fa-floppy-disk mr-2">{{ __('Save') }}
                </x-button-dropdown.mainButton>
            </x-slot>

            <x-button-dropdown.button class="btn-danger"
                    wire:confirm="{{__('Are you sure you want to delete this uploaded file? The file can not be restored afterwards!')}}"
                    wire:click="deleteUploadedFile" title="Delete this uploaded file"
                    iconClass="fa-solid fa-trash">
                {{ __('Delete uploaded file') }}</x-button-dropdown.button>
        </x-button-dropdown.dropdown>
    </div>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <div>
                <x-input-label for="name" :value="__('Name')"/>
                <x-input id="name" name="name" type="text" class="mt-1 block w-full"
                         @php
                             //TODO create own form model
                             @endphp
                         wire:model="$uploadedFile.name"
                         required autofocus autocomplete="name"/>
                @error('$uploadedFile.name')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
        </div>
    </div>
</div>
