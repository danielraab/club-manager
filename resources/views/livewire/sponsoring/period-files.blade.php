@php
    /** @var $period \App\Models\Sponsoring\Period */
    /** @var $uploadedPeriodFile \App\Models\UploadedFile */
    /** @var $periodFile \Livewire\Features\SupportFileUploads\TemporaryUploadedFile */
@endphp
<div>
    <x-message/>

    @if(($uploadedPeriodFiles = $period->uploadedFiles()->get())->isNotEmpty())
        <h3 class="mt-3 text-gray-600">{{__('Uploaded file(s)')}}</h3>

        <ul class="list-disc ml-5 text-sm break-all">
            @foreach($uploadedPeriodFiles as $uploadedPeriodFile)
                <li><a href="{{$uploadedPeriodFile->getUrl()}}" target="_blank" class="underline mr-2">{{$uploadedPeriodFile->name}}</a>
                    <x-default-button class="btn-danger"
                                      wire:click="deleteFile({{$uploadedPeriodFile->id}})"
                                      wire:confirm="{{__('Are you sure you want to delete the file?')}}">
                        <i class="fa-solid fa-trash"></i>
                    </x-default-button>
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-center py-3 text-red-800">-- {{__("no files to show")}} --</div>
    @endif

    <h3 class="mt-3 text-gray-600">{{__('Select new file(s)')}}</h3>
    <x-input-file-area id="periodFiles" name="periodFiles" type="file" class="mt-1 block w-full"
                       wire:model="periodFiles"
                       subTitle="PNG, JPG, GIF up to 10MB" multiple
                       autofocus autocomplete="periodFiles">
        @if(!empty($this->periodFiles))
            <div class="text-center">
                <div class="mt-2">{{__("Selected files:")}}</div>

                <ul class="list-disc text-gray-600 text-sm break-all">
                    @foreach($this->periodFiles as $periodFile)
                        <li>{{$periodFile->getClientOriginalName()}}</li>
                    @endforeach
                </ul>
            </div>
            <x-default-button class="btn-primary" wire:click="uploadFiles">Upload files</x-default-button>
        @endif
    </x-input-file-area>
    @error('periodFiles.*')
    <x-input-error class="mt-2" :messages="$message"/>@enderror
</div>
