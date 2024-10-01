@php
    /** @var $backer \App\Models\Sponsoring\Backer */
    /** @var $uploadedAdDataFile \App\Models\UploadedFile */
    /** @var $adData \Livewire\Features\SupportFileUploads\TemporaryUploadedFile */
@endphp
<div x-init="$store.notificationMessages
            .addNotificationMessages(
            JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))">
    @if(($uploadedAdDataFiles = $backer->uploadedFiles()->get())->isNotEmpty())
        <h3 class="mt-3 text-gray-600">{{__('Uploaded file(s)')}}</h3>

        <ul class="list-disc ml-5 text-sm break-all">
            @foreach($uploadedAdDataFiles as $uploadedAdDataFile)
                <li class="space-x-2">
                    <a href="{{$uploadedAdDataFile->getUrl()}}" target="_blank" class="underline">{{$uploadedAdDataFile->name}}</a>
                    <span class="text-xs text-gray-700">{{$uploadedAdDataFile->created_at}}</span>
                    <button type="button" class="btn btn-danger"
                                      wire:click="deleteFile({{$uploadedAdDataFile->id}})"
                                      wire:confirm="{{__('Are you sure you want to delete the file?')}}">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-center py-3 text-red-800">-- {{__("no files to show")}} --</div>
    @endif

    <h3 class="mt-3 text-gray-600">{{__('Select new file(s)')}}</h3>
    <x-livewire.input-file-area id="adData" name="adData" type="file" class="mt-1 block w-full"
                       wire:model="adDataFiles"
                       subTitle="PNG, JPG, GIF, BMP, WEBP up to 10MB" multiple
                       autofocus autocomplete="adData">
        @if(!empty($this->adDataFiles))
            <div class="text-center">
                <div class="mt-2">{{__("Selected files:")}}</div>

                <ul class="list-disc text-gray-600 text-sm break-all">
                    @foreach($this->adDataFiles as $adData)
                        <li>{{$adData->getClientOriginalName()}}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn btn-primary" wire:click="uploadFiles">Upload files</button>
        @endif
    </x-livewire.input-file-area>
    @error('adDataFiles.*')
    <x-input-error class="mt-2" :messages="$message"/>@enderror
</div>
