@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Sponsoring\Contract::SPONSORING_EDIT_PERMISSION);
    /** @var $contract \App\Models\Sponsoring\Contract */
    /** @var $period \App\Models\Sponsoring\Period */
    /** @var $package \App\Models\Sponsoring\Package */
    /** @var $backer \App\Models\Sponsoring\Backer */
    /** @var $option \App\Models\Sponsoring\AdOption */
    /** @var $member \App\Models\Member */
    /** @var $file \App\Models\UploadedFile */
    $period = $contract->period()->first();
    $backer = $contract->backer()->first();
    $member = $contract->member()->first();
    $package = $contract->package()->first();
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <a href="{{route('sponsoring.period.backer.overview',['period' => $period->id])}}">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </a>
                {{ __('Contract details') }}
            </div>
        </div>
    </x-slot>
    @if($hasEditPermission)
        <x-slot name="headerBtn">
            <a class="btn btn-edit"
               href="{{route('sponsoring.contract.edit', $contract->id)}}"
               title="Edit this contract">{{__("Edit contract")}}</a>
        </x-slot>
    @endif

    <div class="flex flex-wrap gap-3 justify-center">

        <section class="bg-white shadow-sm sm:rounded-lg w-full max-w-screen-sm overflow-hidden"
                 x-data="{showPeriodDetail:$persist(true), showDescription:false, showPackages:false}">
            <h2 class="w-full bg-blue-600 text-center p-2 font-bold cursor-pointer hover:opacity-75"
                x-on:click="showPeriodDetail=!showPeriodDetail">{{__("Period")}}</h2>
            <div class="p-3 flex flex-col gap-2" x-show="showPeriodDetail" x-collapse x-cloak>
                <div>
                    <h3 class="font-semibold">{{__("Title")}}</h3>
                    <p class="p-2">{{$period->title}}</p>
                </div>
                <div>
                    <h3 class="font-semibold cursor-pointer" x-on:click="showDescription=!showDescription">
                    <span>
                        <i class="fa-solid fa-circle-info"></i>
                    {{__("Description")}}
                    </span>
                        <i class="fa-solid" :class="showDescription ? 'fa-minus' : 'fa-plus' "></i>
                    </h3>
                    <p class="p-2" x-show="showDescription" x-cloak x-collapse>{{$period->description}}</p>
                </div>
                <div>
                    <h3 class="font-semibold">{{__("Start")}}</h3>
                    <span class="p-2">{{$period->start}}</span>
                </div>
                <div>
                    <h3 class="font-semibold">{{__("End")}}</h3>
                    <span class="p-2">{{$period->end}}</span>
                </div>
                <div>
                    <h3 class="font-semibold cursor-pointer" x-on:click="showPackages=!showPackages">
                    <span>
                        <i class="fa-solid fa-cubes"></i>
                    {{__("Packages")}}
                    </span>
                        <i class="fa-solid" :class="showPackages ? 'fa-minus' : 'fa-plus' "></i>
                    </h3>
                    <ul class="list-disc ml-5 pl-5" x-cloak x-show="showPackages" x-collapse>
                        @foreach($period->packages()->get() as $packageLoop)
                            <li>{{$packageLoop->title}}
                                - {{\App\Facade\Currency::formatPrice($packageLoop->price)}}</li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold"><i class="fa-solid fa-file"></i> {{__("Period files")}}</h3>
                    @if(($periodFiles = $period->uploadedFiles()->get())->isNotEmpty())
                        <ul class="list-disc ml-5 pl-5">
                            @foreach($periodFiles as $periodFile)
                                <li><a href="{{$periodFile->getUrl()}}" target="_blank"
                                       class="underline mr-2">{{$periodFile->name}}</a></li>
                            @endforeach
                        </ul>
                    @else
                        -- {{__("no files uploaded")}} --
                    @endif
                </div>
            </div>
        </section>

        <section class="bg-white shadow-sm sm:rounded-lg w-full max-w-screen-sm overflow-hidden"
                 x-data="{showBackerDetail:$persist(true), showDescription:false, showPackages:false, showInfo:false}">
            <h2 class="w-full bg-purple-300 text-center p-2 font-bold cursor-pointer hover:opacity-75 relative"
                x-on:click="showBackerDetail=!showBackerDetail">
                {{__("Backer")}}
                @if($backer->enabled || $backer->closed_at)
                    <div class="absolute right-0 top-0 bottom-0 flex flex-col justify-center mx-2 gap-1 text-xs">
                        @if(!$backer->enabled)
                            <div class="bg-red-700 text-white px-3 rounded">{{__("disabled")}}</div>
                        @endif
                        @if($backer->closed_at)
                            <div class="bg-red-700 text-white px-3 rounded">{{__("closed")}}</div>
                        @endif
                    </div>
                @endif
            </h2>
            <div class="p-3 flex flex-col gap-2" x-show="showBackerDetail" x-collapse x-cloak>
                <div>
                    <h3 class="font-semibold"><i class="fa-solid fa-building"></i> {{__("Company name")}}</h3>
                    <p class="p-2">{{$backer->name}}
                        @if($backer->vat)
                            <span class="text-gray-700 text-sm">
                                ({{$backer->vat}})
                            </span>
                        @endif
                    </p>
                </div>
                <div>
                    <h3 class="font-semibold"><i class="fa-solid fa-map-location"></i> {{__("Address")}}</h3>
                    <p class="p-2">{{$backer->street}}, {{$backer->zip}} {{$backer->city}}</p>
                </div>
                <div>
                    <h3 class="font-semibold"><i class="fa-solid fa-address-book"></i> {{__("Contact")}}</h3>
                    <ul class="list-disc ml-5 pl-5">
                        <li>{{$backer->contact_person}}</li>
                        <li>{{$backer->phone}}</li>
                        <li>{{$backer->email}}</li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold cursor-pointer" x-on:click="showInfo=!showInfo">
                    <span>
                        <i class="fa-solid fa-circle-info"></i>
                    {{__("Info")}}
                    </span>
                        <i class="fa-solid" :class="showInfo ? 'fa-minus' : 'fa-plus' "></i>
                    </h3>
                    <p class="p-2" x-show="showInfo" x-cloak x-collapse>{{$backer->info}}</p>
                </div>
                <div>
                    <h3 class="font-semibold"><i class="fa-solid fa-file"></i> {{__("Ad data files")}}</h3>
                    @if(($adDataFiles = $backer->uploadedFiles()->get())->isNotEmpty())
                        <ul class="list-disc ml-5 pl-5">
                            @foreach($adDataFiles as $adDataFile)
                                <li><a href="{{$adDataFile->getUrl()}}" target="_blank"
                                       class="underline mr-2">{{$adDataFile->name}}</a></li>
                            @endforeach
                        </ul>
                    @else
                        -- {{__("no files uploaded")}} --
                    @endif
                </div>

                @if($backer->closed_at)
                    <div>
                        <h3 class="font-semibold"><i class="fa-solid fa-circle-xmark"></i> {{__("Closing date")}}</h3>
                        <span class="p-2">{{$backer->closed_at}}</span>
                    </div>
                @endif
            </div>
        </section>

        <section class="bg-white shadow-sm sm:rounded-lg w-full max-w-screen-sm overflow-hidden"
                 x-data="{showMemberDetail:$persist(true)}">
            <h2 class="w-full bg-green-500 text-center p-2 font-bold cursor-pointer hover:opacity-75 relative"
                x-on:click="showMemberDetail=!showMemberDetail">{{__("Selected Member")}}
                @if($member?->paused || $member?->leaving_date)
                    <div class="absolute right-0 top-0 bottom-0 flex flex-col justify-center mx-2 gap-1 text-xs">
                        @if($member->paused)
                            <div class="bg-red-700 text-white px-3 rounded">{{__("paused")}}</div>
                        @endif
                        @if($member->leaving_date)
                            <div class="bg-red-700 text-white px-3 rounded">{{__("retired")}}</div>
                        @endif
                    </div>
                @endif
            </h2>

            <div class="p-3 flex flex-col gap-2 relative" x-show="showMemberDetail" x-collapse x-cloak>
                @if($member)
                    <div>
                        <h3 class="font-semibold">{{__("Member name")}}</h3>
                        <p class="p-2">{{$member->getFullName()}}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold">{{__("Email")}}</h3>
                        <p class="p-2">{{$member->email}}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold">{{__("Phone")}}</h3>
                        <p class="p-2">{{$member->phone}}</p>
                    </div>
                @else
                    <div class="text-red-600 font-bold">
                        {{__("no member selected")}}
                    </div>
                @endif
            </div>
        </section>

        <section class="bg-white shadow-sm sm:rounded-lg w-full max-w-screen-sm overflow-hidden"
                 x-data="{showPackageDetail:$persist(true), showDescription:false}">
            <h2 class="w-full bg-yellow-600 text-center p-2 font-bold cursor-pointer hover:opacity-75 relative"
                x-on:click="showPackageDetail=!showPackageDetail">{{__("Selected Package")}}
                @if($package && (!$package->enabled || !$package->is_official))
                    <div class="absolute right-0 top-0 bottom-0 flex flex-col justify-center mx-2 gap-1 text-xs">
                        @if(!$package->enabled)
                            <div class="bg-red-700 text-white px-3 rounded">{{__("disabled")}}</div>
                        @endif
                        @if(!$package->is_official)
                            <div class="bg-red-700 text-white px-3 rounded">{{__("inofficial")}}</div>
                        @endif
                    </div>
                @endif
            </h2>

            <div class="p-3 flex flex-col gap-2 relative" x-show="showPackageDetail" x-collapse x-cloak>
                @if($package)
                    <div>
                        <h3 class="font-semibold">{{__("Package name")}}</h3>
                        <p class="p-2">{{$package->title}}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold cursor-pointer" x-on:click="showDescription=!showDescription">
                    <span>
                        <i class="fa-solid fa-circle-info"></i>
                    {{__("Description")}}
                    </span>
                            <i class="fa-solid" :class="showDescription ? 'fa-minus' : 'fa-plus' "></i>
                        </h3>
                        <p class="p-2" x-show="showDescription" x-cloak x-collapse>{{$period->description}}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold"><i class="fa-solid fa-money-bill-wave"></i> {{__("Price")}}</h3>
                        <p class="p-2">{{\App\Facade\Currency::formatPrice($package->price)}}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold"><i class="fa-solid fa-rectangle-ad"></i> {{__("Ad Options")}}</h3>
                        @if(($adOptions = $package->adOptions()->get())->isNotEmpty())
                            <ul class="list-disc ml-5 pl-5">
                                @foreach($adOptions as $optionLoop)
                                    <li>{{$optionLoop->title}}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @else
                    <div class="text-red-600 font-bold">{{__("no package selected")}}</div>
                @endif
            </div>
        </section>
        <section class="bg-white shadow-sm sm:rounded-lg w-full max-w-screen-sm overflow-hidden"
                 x-data="{showContractDetail:$persist(true), showInfo:false}">
            <h2 class="w-full bg-red-600 text-center p-2 font-bold cursor-pointer hover:opacity-75"
                x-on:click="showContractDetail=!showContractDetail">{{__("Contract infos")}}
            </h2>
            <div class="p-3 flex flex-col gap-2 relative" x-show="showContractDetail" x-collapse x-cloak>

                <div>
                    <h3 class="font-semibold cursor-pointer" x-on:click="showInfo=!showInfo">
                    <span>
                        <i class="fa-solid fa-circle-info"></i>
                    {{__("Info")}}
                    </span>
                        <i class="fa-solid" :class="showInfo ? 'fa-minus' : 'fa-plus' "></i>
                    </h3>
                    <p class="p-2" x-show="showInfo" x-cloak x-collapse>{{$contract->info}}</p>
                </div>
                <div>
                    <h3 class="font-semibold"><i class="fa-solid fa-file"></i> {{__("Contract files")}}</h3>
                    @if($contractFile = $contract->uploadedFile()->first())
                        <a href="{{$contractFile->getUrl()}}" target="_blank"
                           class="underline mr-2">{{$contractFile->name}}</a>
                    @else
                        -- {{__("no file uploaded")}} --
                    @endif
                </div>
                <div>
                    <h3 class="font-semibold">{{__("Refused")}}</h3>
                    <span class="p-2">{{$contract->refused ?: '---'}}</span>
                </div>
                <div>
                    <h3 class="font-semibold">{{__("Contract received")}}</h3>
                    <span class="p-2">{{$contract->contract_received ?: '---'}}</span>
                </div>
                <div>
                    <h3 class="font-semibold">{{__("Ad data received")}}</h3>
                    <span class="p-2">{{$contract->ad_data_received ?: '---'}}</span>
                </div>
                <div>
                    <h3 class="font-semibold">{{__("Paid")}}</h3>
                    <span class="p-2">{{$contract->paid ?: '---'}}</span>
                </div>
            </div>
        </section>
    </div>
</x-backend-layout>
