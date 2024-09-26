@php
    /** @var \App\Livewire\Forms\UploadedFileForm $uploadedFileForm */
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
                                              title="Save current changes"
                                              iconClass="fa-solid fa-floppy-disk mr-2">{{ __('Save') }}
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
        <div class="bg-white shadow-sm sm:rounded-lg p-4 space-y-3">
            <div>
                <x-input-label for="name" :value="__('Name')"/>
                <x-input id="name" name="name" type="text" class="mt-1 block w-full"
                         wire:model="uploadedFileForm.name"
                         required autofocus autocomplete="name"/>
                @error('uploadedFileForm.name')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
            <div>
                <x-input-label for="mimeType" :value="__('Mime Type')"/>
                <x-input id="name" name="name" type="text" class="mt-1 block w-full"
                         wire:model="uploadedFileForm.mimeType"
                         required autofocus/>
                @error('uploadedFileForm.mimeType')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
            <div class="ml-3">
                <x-input-checkbox id="isPublic" name="isPublic"
                                  wire:model="uploadedFileForm.isPublic"
                                  class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    {{ __('is public') }}<i class="fa-solid fa-circle-info text-gray-500 ml-2"
                                            title="{{__("Public files can be accessed to unauthorized users.")}}"></i>
                </x-input-checkbox>
            </div>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <div>
                <x-input-label for="path" :value="__('Path')"/>
                <x-input id="path" name="path" type="text" class="mt-1 block w-full"
                         required autofocus disabled value="{{$uploadedFileForm->uploadedFile->path}}"/>
            </div>
            <div>
                <h3 class="mt-3 text-gray-600">{{__('Select a File')}}</h3>
                <x-livewire.input-file-area id="newFile" name="newFile" type="file" class="mt-1 block w-full"
                                            wire:model="newFile"
                                            subTitle="Select a matching file"
                                            autofocus autocomplete="newFile">
                    @if($newFile)
                        <div class="text-center">
                            <div class="mt-2">{{__("Selected file:")}}</div>

                            <p class="list-disc text-gray-600 text-sm break-all">
                                {{$newFile->getClientOriginalName()}}
                            </p>
                        </div>
                        <button type="button" class="btn btn-primary" wire:click="changeFile">Change file</button>
                    @endif
                </x-livewire.input-file-area>
            </div>
        </div>
    </div>
</div>
