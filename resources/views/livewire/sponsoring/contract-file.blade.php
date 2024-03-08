@php
    /** @var $contract \App\Models\Sponsoring\Contract */
    /** @var $savedContractFile \App\Models\UploadedFile */
    /** @var $contractFile \Livewire\Features\SupportFileUploads\TemporaryUploadedFile */
@endphp
<div>
    <script>
        Alpine.store('notificationMessages').addNotificationMessages(
            JSON.parse('<?= \App\Facade\NotificationMessage::popNotificationMessagesJson() ?>'));
    </script>

    @if($savedContractFile = $contract->uploadedFile()->first())
        <h3 class="mt-3 text-gray-600">{{__('Uploaded file')}}</h3>

        <div class="flex items-center gap-2 mx-3">
            <i class="fa-solid fa-file"></i>
            <a href="{{$savedContractFile->getUrl()}}" target="_blank"
               class="underline">{{$savedContractFile->name}}</a>
            <x-default-button class="btn-danger"
                              wire:click="deleteFile({{$savedContractFile->id}})"
                              wire:confirm="{{__('Are you sure you want to delete the file?')}}">
                <i class="fa-solid fa-trash"></i>
            </x-default-button>
        </div>
    @else
        <h3 class="mt-3 text-gray-600">{{__('Select a File')}}</h3>
        <x-input-file-area id="contractFile" name="contractFile" type="file" class="mt-1 block w-full"
                           wire:model="contractFile"
                           subTitle="PNG, JPG, GIF up to 10MB"
                           autofocus autocomplete="contractFile">
            @if($contractFile)
                <div class="text-center">
                    <div class="mt-2">{{__("Selected file:")}}</div>

                    <p class="list-disc text-gray-600 text-sm break-all">
                           {{$contractFile->getClientOriginalName()}}
                    </p>
                </div>
                <x-default-button class="btn-primary" wire:click="uploadFile">Upload file</x-default-button>
            @endif
        </x-input-file-area>
        @error('contractFile')
        <x-input-error class="mt-2" :messages="$message"/>@enderror

    @endif
</div>
