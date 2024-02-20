<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Backer') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Enter basic information of the backer.") }}
        </p>
    </header>

    <div class="mt-6">

        <div>
            <x-input-checkbox id="enabled" name="enabled" wire:model="backerForm.enabled"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Is enabled') }} <i class="fa-solid fa-circle-info text-gray-500 ml-2"
                                          title="{{__("The backer is enabled.")}}"></i>
            </x-input-checkbox>
        </div>

        <div class="mt-3">
            <x-input-label for="adData" :value="__('File(s)')"/>
            @foreach($this->adDataArr as $adData)
                @php
                /** @var $adData \Livewire\Features\SupportFileUploads\TemporaryUploadedFile */
                @endphp
            @dump($adData)
                <div>{{$adData->getFileInfo()->getFilename()}}</div>
            @endforeach
            <x-input-file-area id="adData" name="adData" type="file" class="mt-1 block w-full"
                          wire:model="adDataArr"
                               subTitle="PNG, JPG, GIF up to 10MB" multiple
                          autofocus autocomplete="adData"/>
            @error('adDataArr.*')<x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>


        <div class="mt-3">
            <x-input-label for="closedAt" :value="__('Closed at')"/>
            <x-input-date id="closedAt" name="closedAt" class="mt-1 block w-full"
                          wire:model="backerForm.closed_at"
                          autofocus autocomplete="closedAt"/>
            @error('backerForm.closed_at')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="mt-3">
            <x-input-label for="info" :value="__('Info')"/>
            <x-textarea id="info" name="info" class="mt-1 block w-full"
                          wire:model="backerForm.info"
                          autofocus autocomplete="info"/>
            @error('backerForm.info')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
    </div>
</section>
