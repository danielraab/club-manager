@php
    /** @var $contractForm \App\Livewire\Forms\Sponsoring\ContractForm */
    /** @var $period \App\Models\Sponsoring\Period */
    $period = $contractForm->contract->period()->first();

    /** @var $backer \App\Models\Sponsoring\Backer */
    $backer = $contractForm->contract->backer()->first();

    /** @var $member \App\Models\Member */
    /** @var $package \App\Models\Sponsoring\Package */
@endphp
<x-slot name="headline">
    <div class="flex items-center gap-2">
        <a href="{{route("sponsoring.period.backer.overview",$period->id)}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Edit contract") }}
    </div>
</x-slot>

<div>
    <x-livewire.loading />
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
                <span>{{$period->title}}</span>
            </div>
            <div>
                <span class="font-bold">{{__("Backer")}}:</span>
                <span>{{$backer->name}}</span>
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
                <x-input-label for="member">
                    <i class="fa-solid fa-user"></i>
                    {{__('Member')}}
                </x-input-label>
                <select name="member" id="member"
                        wire:model="contractForm.member_id"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                >
                    <option>{{__("-- choose a member --")}}</option>
                    @foreach(App\Models\Member::getAllFiltered(new \App\Models\Filter\MemberFilter(true, true, true))->get() as $member)
                        <option value="{{$member->id}}">{{$member->getFullName()}}</option>
                    @endforeach
                </select>
                @if(($member = $contractForm->contract->member()->first()))
                    <span class="text-sm text-gray-500">{{__("currently selected: ")}} {{$member->getFullName()}}</span>
                @endif
            </div>
            <div class="mt-3">
                <x-input-label for="package">
                    <i class="fa-solid fa-cube"></i>
                    {{__('Package')}}
                </x-input-label>
                <select name="package" id="package"
                        wire:model="contractForm.package_id"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                >
                    <option>{{__("-- choose a package --")}}</option>
                    @foreach($period->packages()->get() as $package)
                        <option value="{{$package->id}}">{{$package->title}}</option>
                    @endforeach
                </select>
                @if(($package = $contractForm->contract->package()->first()))
                    <div>
                    <span class="text-sm text-gray-500">{{__("currently selected: ")}}
                        {{$package->title}} - {{\App\Facade\Currency::formatPrice($package->price)}}
                    </span>

                    </div>
                @endif
            </div>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <div class="mt-3">
                <x-input-label for="refused">
                    <i class="fa-solid fa-ban"></i>
                    {{__('Refused')}}
                </x-input-label>
                <div class="flex gap-3 mt-1">
                    <x-input-date id="refused" name="refused" class="grow"
                                  wire:model.live="contractForm.refused"
                                  autofocus autocomplete="refused"/>
                    <x-default-button class="btn-secondary"
                                      :disabled="!empty($contractForm->refused)"
                                      wire:click="$set('contractForm.refused', new Date().toJSON().slice(0, 10))">{{__("Today")}}</x-default-button>
                </div>
                @error('contractForm.refused')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
            <div class="mt-3">
                <x-input-label for="contract_received">
                    <i class="fa-solid fa-file-contract"></i>
                    {{__('Contract received')}}
                </x-input-label>
                <div class="flex gap-3 mt-1">
                    <x-input-date id="contract_received" name="contract_received" class="block w-full"
                                  wire:model.live="contractForm.contract_received"
                                  :disabled="!empty($contractForm->refused)"
                                  autofocus autocomplete="contract_received"/>
                    <x-default-button class="btn-secondary"
                                      :disabled="!empty($contractForm->refused) || !empty($contractForm->contract_received)"
                                      wire:click="$set('contractForm.contract_received', new Date().toJSON().slice(0, 10))">{{__("Today")}}</x-default-button>
                </div>
                @error('contractForm.contract_received')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
            <div class="mt-3">
                <x-input-label for="ad_data_received">
                    <i class="fa-regular fa-image"></i>
                    {{__('Ad data received')}}
                </x-input-label>
                <div class="flex gap-3 mt-1">
                    <x-input-date id="ad_data_received" name="ad_data_received" class="block w-full"
                                  wire:model.live="contractForm.ad_data_received"
                                  :disabled="!empty($contractForm->refused)"
                                  autofocus autocomplete="ad_data_received"/>
                    <x-default-button class="btn-secondary"
                                      :disabled="!empty($contractForm->refused) || !empty($contractForm->ad_data_received)"
                                      wire:click="$set('contractForm.ad_data_received', new Date().toJSON().slice(0, 10))">{{__("Today")}}</x-default-button>
                </div>
                @error('contractForm.ad_data_received')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
            <div class="mt-3">
                <x-input-label for="paid">
                    <i class="fa-solid fa-money-bill-wave"></i>
                    {{__('Paid')}}
                </x-input-label>
                <div class="flex gap-3 mt-1">
                    <x-input-date id="paid" name="paid" class="block w-full"
                                  wire:model.live="contractForm.paid"
                                  :disabled="!empty($contractForm->refused)"
                                  autofocus autocomplete="paid"/>
                    <x-default-button class="btn-secondary"
                                      :disabled="!empty($contractForm->refused) || !empty($contractForm->paid)"
                                      wire:click="$set('contractForm.paid', new Date().toJSON().slice(0, 10))">{{__("Today")}}</x-default-button>
                </div>
                @error('contactForm.paid')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
        </div>

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{__("Contract file")}}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Manage signed contract file.") }}
                    </p>
                </header>

                <livewire:sponsoring.contract-file :contract="$contractForm->contract"/>
            </section>
        </div>

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{__("Ad data files")}}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Manage files for ads of backer. Files are stored with the backer.") }}
                    </p>
                </header>

                <livewire:sponsoring.backer-files :backer="$backer"/>
            </section>
        </div>
    </div>

</div>
