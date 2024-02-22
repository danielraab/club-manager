@php
    /** @var $backer \App\Models\Sponsoring\Backer */
    /** @var $adDataFile \App\Models\UploadedFile */
    /** @var $adData \Livewire\Features\SupportFileUploads\TemporaryUploadedFile */
@endphp
<div>
    @if(($adDataFiles = $backer->uploadedFiles()->get())->isNotEmpty())
        <x-input-label class="mt-3" for="adData" :value="__('Uploaded file(s)')"/>

        <ul class="list-disc ml-5 text-sm break-all">
            @foreach($adDataFiles as $adDataFile)
                <li><a href="{{$adDataFile->getUrl()}}" target="_blank" class="underline mr-2">{{$adDataFile->name}}</a>
                    <x-default-button class="btn-danger"
                                      wire:click="deleteFile({{$adDataFile->id}})"
                                      wire:confirm="{{__('Are you sure you want to delete the file?')}}">
                        <i class="fa-solid fa-trash"></i>
                    </x-default-button>
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-center py-3 text-red-800">-- {{__("no files to show")}} --</div>
    @endif

    <x-message />

    <x-input-label class="mt-3" for="adData" :value="__('Select new File(s)')"/>
    <x-input-file-area id="adData" name="adData" type="file" class="mt-1 block w-full"
                       wire:model="adDataArr"
                       subTitle="PNG, JPG, GIF up to 10MB" multiple
                       autofocus autocomplete="adData">
        @if(!empty($this->adDataArr))
            <div class="text-center">
                <div class="mt-2">{{__("Selected files:")}}</div>

                <ul class="list-disc text-gray-600 text-sm break-all">
                    @foreach($this->adDataArr as $adData)
                        <li>{{$adData->getClientOriginalName()}}</li>
                    @endforeach
                </ul>
            </div>
            <x-default-button class="btn-primary" wire:click="uploadFiles">Upload files</x-default-button>
        @endif
    </x-input-file-area>
    @error('adDataArr.*')
    <x-input-error class="mt-2" :messages="$message"/>@enderror
</div>
