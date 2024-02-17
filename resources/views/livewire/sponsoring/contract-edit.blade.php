<x-slot name="headline">
    <div class="flex items-center gap-2">
        <a href="{{route("sponsoring.period.backer.overview",$contractForm->contract->period_id)}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Edit contract") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex justify-between items-center">
        <x-default-button
            x-data="{ clickCnt: 0, onClick() {
                        if(this.clickCnt > 0) {
                            $wire.deleteContract();
                        } else {
                            this.clickCnt++;
                            $el.innerHTML = 'Are you sure?';
                        }
                    }}"
            x-on:click="onClick()" title="Delete this contract"
            class="btn-danger">{{ __('Delete contract') }}</x-default-button>
        <x-default-button class="btn-primary" wire:click="saveContract"
                          title="Update contract">{{ __('Save') }}</x-default-button>
    </div>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <div>
                <span class="font-bold">{{__("Period")}}:</span>
                <span>{{$contractForm->contract->period()->first()->title}}</span>
            </div>
            <div>
                <span class="font-bold">{{__("Backer")}}:</span>
                <span>{{($backer = $contractForm->contract->backer()->first())->name}}</span>
                <span class="text-gray-700"> - {{$backer->zip}} {{$backer->city}}</span>
            </div>
            <div class="mt-3">
                <x-input-label for="info" :value="__('Info')"/>
                <x-textarea id="info" name="info" type="text" class="mt-1 block w-full"
                            wire:model="contractForm.info"
                            autofocus autocomplete="info"/>
                @error('contactForm.info')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
            <div class="mt-3">
                {{--                todo select--}}
                member
            </div>
            <div class="mt-3">
{{--                todo select--}}
                package
            </div>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4"
             x-data="{
             refused:@entangle('contractForm.refused'),
             contract_received:@entangle('contractForm.contract_received'),
             ad_data_received:@entangle('contractForm.ad_data_received'),
             paid:@entangle('contractForm.paid'),
             }">
            <div class="mt-3">
                <x-input-label for="refused" :value="__('Refused')"/>
                <div class="flex gap-3 mt-1">
                    <x-input-date id="refused" name="refused" class="grow"
                                  x-model="refused"
                                  autofocus autocomplete="refused"/>
                    <x-default-button class="btn-secondary"
                    x-on:click="refused = new Date().toJSON().slice(0, 10)">{{__("Today")}}</x-default-button>
                </div>
                @error('contactForm.refused')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
            <div class="mt-3">
                <x-input-label for="contract_received" :value="__('Contract received')"/>
                <div class="flex gap-3 mt-1">
                    <x-input-date id="contract_received" name="contract_received" class="block w-full"
                                  wire:model="contractForm.contract_received"
                                  x-bind:disabled="refused"
                                  autofocus autocomplete="contract_received"/>
                    <x-default-button class="btn-secondary"
                                      x-bind:disabled="refused || contract_received"
                                      x-on:click="contract_received = new Date().toJSON().slice(0, 10)">{{__("Today")}}</x-default-button>
                </div>
                @error('contactForm.contract_received')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
            <div class="mt-3">
                <x-input-label for="ad_data_received" :value="__('Ad data received')"/>
                <div class="flex gap-3 mt-1">
                    <x-input-date id="ad_data_received" name="ad_data_received" class="block w-full"
                                  wire:model="contractForm.ad_data_received"
                                  x-bind:disabled="refused"
                                  autofocus autocomplete="ad_data_received"/>
                    <x-default-button class="btn-secondary"
                                      x-bind:disabled="refused || ad_data_received"
                                      x-on:click="ad_data_received = new Date().toJSON().slice(0, 10)">{{__("Today")}}</x-default-button>
                </div>
                @error('contactForm.ad_data_received')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
            <div class="mt-3">
                <x-input-label for="paid" :value="__('Paid')"/>
                <div class="flex gap-3 mt-1">
                    <x-input-date id="paid" name="paid" class="block w-full"
                                  wire:model="contractForm.paid"
                                  x-bind:disabled="refused"
                                  autofocus autocomplete="paid"/>
                    <x-default-button class="btn-secondary"
                                      x-bind:disabled="refused || paid"
                                      x-on:click="paid = new Date().toJSON().slice(0, 10)">{{__("Today")}}</x-default-button>
                </div>
                @error('contactForm.paid')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
        </div>
    </div>

</div>
