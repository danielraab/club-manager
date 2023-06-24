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
                        {{ __('Import file') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Select CSV file with max. 1MB") }}
                    </p>
                </header>
                <div class="flex flex-wrap items-top justify-between mt-5 gap-5">
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
                <div class="flex flex-row-reverse mt-5">
                    <x-default-button class="btn-primary" wire:click="evaluateFile"
                                      title="Read selected file">{{ __('Read file') }}</x-default-button>
                </div>
            </section>
        </div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-5 p-5 ">
        <section>
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Field mapping') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{$fileInformation}}
                </p>
            </header>

        @if($columnArray)
            <div class="flex flex-wrap flex-row justify-around gap-3 mt-5">
            <div>
                <x-input-label for="fristname" :value="__('Fristname')"/>
                <select id="firstname" name="firstname" class="mt-2">
                    <option></option>
                    @foreach($columnArray as $column)
                        <option value="{{$column}}">{{$column}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <x-input-label for="lastname" :value="__('Lastname')"/>
                <select id="lastname" name="lastname" class="mt-2">
                    <option></option>
                    @foreach($columnArray as $column)
                        <option value="{{$column}}">{{$column}}</option>
                    @endforeach
                </select>
            </div>
    </div>
            <div class="flex justify-end mt-5">

                <x-default-button class="btn-danger" wire:click="import"
                                  title="Import file">{{ __('import file') }}</x-default-button>
            </div>
        @endif
        </section>
    </div>
</div>

</div>
