@php
    /** @var $period \App\Models\Sponsoring\Period */
    /** @var $package \App\Models\Sponsoring\Package */
    /** @var $contract \App\Models\Sponsoring\Contract */
    /** @var $backer \App\Models\Sponsoring\Backer */
    /** @var $adOption \App\Models\Sponsoring\AdOption */
    /** @var $file \App\Models\UploadedFile */
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{route("sponsoring.index")}}">
                <i class="fa-solid fa-arrow-left-long"></i>
            </a>
            <span class="text-gray-500">{{ __('Ad positions of period') }}:</span>
            <span>{{$period->title}}</span>
        </div>
    </x-slot>

    <div class="bg-white shadow-sm sm:rounded-lg p-4 flex flex-col gap-3">
        <livewire:sponsoring.ad-placement/>
        @forelse($adOptionList as $adOptionListItem)
            @php
                $adOption = $adOptionListItem["adOption"];
                $backerList = $adOptionListItem["backerList"];
            @endphp
            <div class="rounded border overflow-hidden">
                <div class="{{isset($adOptionListItem['isNotInPackages']) ? 'bg-red-500' : 'bg-gray-300'}} p-3">
                    {{$adOption->title}}
                </div>
                <div class="p-3">
                    @if(!empty($backerList))
                        <ul class="list-disc ml-5">
                            @foreach($backerList as $backerItem)
                                @php
                                    $contract = $backerItem["contract"];
                                    $backer = $backerItem["backer"];
                                    $package = $backerItem["package"];
                                    $adDataFiles = $backer->uploadedFiles()->get()
                                @endphp
                                <li>
                                    <div x-data="{showFiles:false}">
                                        <div class="cursor-pointer"
                                             x-on:click="showFiles=!showFiles">
                                            <span class="@if($backerItem["adPlacementDone"]) text-green-800 @endif">
                                            {{$backer->name}} ({{$package->title}})
                                            </span>
                                            <i class="fa-solid"
                                               :class="showFiles ? 'fa-caret-down' : 'fa-caret-right'"></i>
                                        </div>
                                        <button type="button" class="btn btn-primary"
                                                @click="$dispatch('update-modal-and-show',
                                                       {
                                                         contract: {{ $contract->id }},
                                                         adOption: {{ $adOption->id }}
                                                       })"
                                        >test
                                        </button>
                                        <div x-show="showFiles" x-cloak x-collapse>
                                            @if($adDataFiles->isNotEmpty())
                                                <ul class="list-disc ml-5 break-all">
                                                    @foreach($adDataFiles as $file)
                                                        <li><a href="{{$file->getUrl()}}" target="_blank"
                                                               class="underline mr-2">{{$file->name}}</a></li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-red-600">-- {{__("no files")}} --</span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        {{__(("no backers"))}}
                    @endif
                </div>
            </div>
        @empty
            <span class="text-gray-600 text-center">-- {{__("no ad options")}} --</span>
        @endforelse
    </div>
</x-backend-layout>
