<x-slot name="headline">
    <div class="flex items-center gap-2">
        <a href="{{route("sponsoring.backer.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Edit backer") }}
    </div>
</x-slot>

<div>
    <x-livewire.loading/>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex justify-between items-center">
        <button type="button"
                x-data="{ clickCnt: 0, onClick() {
                        if(this.clickCnt > 0) {
                            $wire.deleteBacker();
                        } else {
                            this.clickCnt++;
                            $el.innerHTML = 'Are you sure?';
                        }
                    }}"
                x-on:click="onClick()" title="Delete this backer"
                class="btn btn-danger">{{ __('delete backer') }}</button>
        <button type="button" class="btn btn-primary" wire:click="saveBacker"
                title="Update backer">{{ __('Save') }}</button>
    </div>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.sponsoring.backer-content/>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Additional info') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Enter additional information for the backer.") }}
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


                    <livewire:sponsoring.backer-files :backer="$backerForm->backer"/>
                </div>
            </section>

        </div>
    </div>

</div>
