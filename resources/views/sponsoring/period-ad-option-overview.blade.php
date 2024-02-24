@php
    /** @var $period \App\Models\Sponsoring\Period */
    /** @var $package \App\Models\Sponsoring\Package */
    /** @var $contract \App\Models\Sponsoring\Contract */
    /** @var $backer \App\Models\Sponsoring\Backer */
    /** @var $file \App\Models\UploadedFile */
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-gray-500">{{ __('Ad options for period overview') }}:</span>
            <span>{{$period->title}}</span>
        </div>
    </x-slot>

    <div class="bg-white shadow-sm sm:rounded-lg p-4 flex flex-col gap-3">
        @foreach($period->packages()->get() as $package)
            <div class="rounded overflow-hidden">
                <div class="bg-gray-300 p-3">
                    {{$package->title}}
                </div>
                <div class="border p-3">
                    @php($contracts = $period->contracts()->where("sponsor_contracts.package_id", $package->id)->get())
                    @if($contracts->isNotEmpty())
                        <ul class="list-disc ml-5">
                            @foreach($contracts as $contract)
                                @php($backer = $contract->backer()->first())
                                @php($adDataFiles = $backer->uploadedFiles()->get())
                                <li>
                                    <div x-data="{showFiles:false}">
                                        <div class="cursor-pointer"
                                             x-on:click="showFiles=!showFiles">{{$backer->name}}
                                            <i class="fa-solid"
                                               :class="showFiles ? 'fa-caret-down' : 'fa-caret-right'"></i>
                                        </div>
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
                        {{__(("no contracts"))}}
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</x-backend-layout>
