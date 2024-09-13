@php
    /** @var $period \App\Models\Sponsoring\Period */
    /** @var $backer \App\Models\Sponsoring\Backer */
    /** @var $periodFile \App\Models\UploadedFile */

    $green = "text-green-700";
    $yellow = "text-yellow-600";
    $red = "text-red-600";
    $gray = "text-gray-400";

@endphp
<x-slot name="headline">
    <div class="flex items-center gap-2">
        <a href="{{route("sponsoring.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        <span class="text-gray-500">{{__("Period")}}:</span> {{$period->title}}
    </div>
</x-slot>

<div x-init="$store.notificationMessages
        .addNotificationMessages(
        JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))">
    <x-livewire.loading/>
    @if($hasEditPermission && $period->end > now())
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3 p-5 gap-2 flex justify-end items-center">
            <div class="flex items-center gap-2" x-data="{showLegend:false}">
                <button type="button" x-ref="legendBtn" class="" x-on:click="showLegend= !showLegend">
                    <i class="fa-solid fa-circle-info text-blue-700"></i>
                </button>
                <div x-anchor="$refs.legendBtn" x-show="showLegend" x-cloak x-on:click.outside="showLegend = false"
                     class="z-10 bg-white rounded px-5 py-2 border border-black m-1 shadow-xl text-sm">
                    <table>
                        <tbody>
                        <tr>
                            <td><i class="fa-solid fa-circle-info text-cyan-900"></i></td>
                            <td>{{__("show contract details")}}</td>
                        </tr>

                        <tr class="border-t">
                            <td><i class="fa-solid fa-user {{$green}}"></i></td>
                            <td>{{__("no member selected")}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-user {{$red}}"></i></td>
                            <td>{{__("no member selected")}}</td>
                        </tr>

                        <tr class="border-t">
                            <td><i class="fa-solid fa-ban {{$red}}"></i></td>
                            <td>{{__("contract is declined")}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-ban {{$gray}}"></i></td>
                            <td>{{__("contract not declined (yet)")}}</td>
                        </tr>

                        <tr class="border-t">
                            <td><i class="fa-solid fa-cube {{$green}}"></i></td>
                            <td>{{__("package is selected")}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-cube {{$gray}}"></i></td>
                            <td>{{__("no package is selected")}}</td>
                        </tr>

                        <tr class="border-t">
                            <td><i class="fa-solid fa-file-contract {{$green}}"></i></td>
                            <td>{{__("contract is uploaded")}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-file-contract {{$yellow}}"></i></td>
                            <td>{{__("contract is marked as received but not uploaded")}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-file-contract {{$gray}}"></i></td>
                            <td>{{__("no information about contract")}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-file-contract {{$red}}"></i></td>
                            <td>{{__("no information about contract but package is already selected")}}</td>
                        </tr>

                        <tr class="border-t">
                            <td><i class="fa-regular fa-image {{$green}}"></i></td>
                            <td>{{__("new up to date ad data is received")}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa-regular fa-image text-blue-700"></i></td>
                            <td>{{__("ad data is available but is not up to date")}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa-regular fa-image {{$yellow}}"></i></td>
                            <td>{{__("ad data is marked as received but not uploaded")}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa-regular fa-image {{$gray}}"></i></td>
                            <td>{{__("ad data is not available")}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa-regular fa-image {{$red}}"></i></td>
                            <td>{{__("ad data is not available but a package is already selected")}}</td>
                        </tr>

                        <tr class="border-t">
                            <td><i class="fa-solid fa-money-bill-wave {{$green}}"></i></td>
                            <td>{{__("backer has paid")}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-money-bill-wave {{$gray}}"></i></td>
                            <td>{{__("backer has not paid yet")}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-money-bill-wave {{$red}}"></i></td>
                            <td>{{__("backer has not paid yet but package is already selected")}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <x-button-dropdown.dropdown>
                <x-slot name="mainButton">
                    <x-button-dropdown.mainLink href="{{route('sponsoring.period.edit', $period->id)}}"
                                                class="btn-primary"
                                                title="Edit this period"
                                                iconClass="fa-solid fa-pen-to-square"
                    >
                        {{__("Edit period")}}
                    </x-button-dropdown.mainLink>
                </x-slot>
                <x-button-dropdown.button
                        class="btn-secondary"
                        wire:confirm.prompt="{{__('Do you want to generate a contract for every backer ?')}}"
                        wire:click="generateAllContracts"
                        title="Generate a contract for every backer."
                        iconClass="fa-solid fa-wand-magic-sparkles"
                >
                    {{ __('Generate contracts') }}
                </x-button-dropdown.button>
                <x-button-dropdown.link
                    class="btn-secondary"
                    href="{{route('sponsoring.period.export.csv', $period->id)}}"
                    iconClass="fa-solid fa-file-export"
                >
                    {{__("Export overview")}}
                </x-button-dropdown.link>
                <x-button-dropdown.link
                    class="btn-secondary"
                    href="{{route('sponsoring.period.memberAssignment', $period->id)}}"
                    iconClass="fa-solid fa-user-group"
                >
                    {{__("Assign per member")}}
                </x-button-dropdown.link>
                <x-button-dropdown.button
                    class="btn-secondary"
                    x-on:click.prevent="$dispatch('open-modal', 'send-reminder-modal')"
                    title="Send a reminder Mail to all open contract members."
                    iconClass="fa-solid fa-business-time"
                >
                    {{ __('Send a reminder Mail') }}
                </x-button-dropdown.button>
            </x-button-dropdown.dropdown>
        </div>

        <x-modal id="send-reminder-modal" title="Send remainder to members" showX>
            @php
            /** @var \App\Models\Sponsoring\Contract $contract */
            @endphp
            @if($this->openContractWithMember->count() > 0)
                <div class="p-3">
                    <ul class="list-disc ml-4">
                        @foreach($this->openContractWithMember as $contract)
                            <li>{{$contract->backer->name}} - {{$contract->member->getFullName()}}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="flex justify-between mt-4 p-3">
                    <button class="btn btn-primary" type="button" x-on:click="$dispatch('close-modal', 'send-reminder-modal')">close</button>
                    <button class="btn btn-create" type="button"
                            wire:confirm="{{__('Are you sure to send the notification mail ?')}}"
                            wire:click="sendNotificationMail">{{__('Send notification mail')}}</button>
                </div>
            @else
                <div class="p-3">
                    {{ __("No open contracts with assigned members.") }}
                </div>
            @endif
        </x-modal>
    @endif

    @if(($periodFiles = $period->uploadedFiles()->get())->isNotEmpty())
        <div class="flex flex-wrap mb-5 mx-2">
            <span>{{__("Period files:")}}</span>
            <ul class="list-disc flex flex-wrap mx-2">
                @foreach($periodFiles as $periodFile)
                    <li class="mx-3"><a href="{{$periodFile->getUrl()}}" target="_blank"
                                        class="underline mr-2">{{$periodFile->name}}</a>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow-sm sm:rounded-lg p-5">
        <div class="divide-y divide-black">
            @forelse($backerList["enabled"] as $backer)
                <x-livewire.sponsoring.period-backer-item
                    :backer="$backer['backer']"
                    :contract="$backer['contract']"
                    wire:key="{{$backer['backer']->id}}"
                    :hasEditPermission="$hasEditPermission"/>
            @empty
                <div class="text-gray-600 text-center">-- {{__("no backers")}} --</div>
            @endforelse
        </div>
        @if(!empty($backerList["disabled"]))
            <div class="font-bold bg-gray-700 text-white py-2 px-4 mt-2">{{__("disabled")}}</div>
            <div class="divide-y divide-black border border-gray-700">
                @foreach($backerList["disabled"] as $backer)
                    <x-livewire.sponsoring.period-backer-item
                        :backer="$backer['backer']"
                        :contract="$backer['contract']"
                        wire:key="{{$backer['backer']->id}}"
                        :hasEditPermission="$hasEditPermission"/>
                @endforeach
            </div>
        @endif
        @if(!empty($backerList["closed"]))
            <div class="font-bold bg-gray-700 text-white py-2 px-4 mt-2">{{__("closed")}}</div>
            <div class="divide-y divide-black border border-gray-700">
                @foreach($backerList["closed"] as $backer)
                    <x-livewire.sponsoring.period-backer-item
                        :backer="$backer['backer']"
                        :contract="$backer['contract']"
                        wire:key="{{$backer['backer']->id}}"
                        :hasEditPermission="$hasEditPermission"/>
                @endforeach
            </div>
        @endif
    </div>

    <div class="flex flex-wrap gap-3 justify-around bg-white shadow-sm sm:rounded-lg mt-5 p-5">
        <div>
            <span>{{__("Created contracts")}}:</span>
            <span>{{$period->contracts()->count()}}</span>
        </div>
        <div>
            <span>{{__("member assigned")}}:</span>
            <span>{{$period->contracts()->has("member")->count()}}</span>
        </div>
        <div>
            <span>{{__("Refused")}}:</span>
            <span>{{$period->contracts()->whereNotNull("refused")->count()}}</span>
        </div>
        <div>
            <span>{{__("Package selected")}}:</span>
            <span>{{$period->contracts()->has("package")->count()}}</span>
            <span>({{\App\Facade\Currency::formatPrice(
    $period->contracts()->join("sponsor_packages",
    "sponsor_packages.id", "=", "sponsor_contracts.package_id")->sum("price"))}})</span>
        </div>
        <div>
            <span>{{__("Paid")}}:</span>
            <span>{{$period->contracts()->whereNotNull("paid")->count()}}</span>
            <span>({{\App\Facade\Currency::formatPrice(
    $period->contracts()->whereNotNull("paid")->join("sponsor_packages",
    "sponsor_packages.id", "=", "sponsor_contracts.package_id")->sum("price"))}})</span>
        </div>
    </div>
</div>
