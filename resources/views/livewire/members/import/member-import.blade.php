<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Member import") }}
    </div>
</x-slot>

<div>
    <div class="md:flex justify-center">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 sm:p-8 max-w-xl">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Select file') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Select :filetype file with max. :size", ["filetype"=>"CSV", "size"=> "1MB"]) }}
                    </p>
                </header>
                <div class="flex flex-wrap items-top justify-center mt-5 gap-5">
                    <div>
                        <x-input-label for="csvFile" :value="__('File')"/>
                        <input id="csvFile" name="csvFile" type="file" class="mt-3"
                               accept=".csv" wire:model.lazy="csvFile" required autofocus autocomplete="csvFile"/>
                        @error('csvFile')
                        <x-input-error class="mt-2" :messages="$message"/>
                        @enderror
                    </div>
                    <div>
                        <x-input-label for="separator" :value="__('Separator')"/>
                        <select id="separator" name="separator" wire:model.lazy="separator"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                            <option value=";">;</option>
                            <option value=",">,</option>
                        </select>
                    </div>
                </div>
                <div class="w-full text-right mt-5">
                    <div wire:loading class="fa fa-spinner fa-spin mr-3"></div>
                        <x-default-button class="btn-primary" wire:click="evaluateFile" wire:loading.attr="disabled"
                                          wire:target="evaluateFile, csvFile"
                                          title="Read selected file">{{ __('Read file') }}</x-default-button>
                </div>
            </section>
        </div>
    </div>

    @if($csvColumns)
        <livewire:members.import.field-sync :rawData="$rawData" :csvColumns="$csvColumns" :key="$csvColumnsHash"/>
    @else
        <div class="flex justify-center mt-5">
            <p class="text-sm text-gray-600">
                {{$fileInfoMessage}}
            </p>
        </div>
    @endif
</div>
