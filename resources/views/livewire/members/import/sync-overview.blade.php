<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-5 p-5 ">
    <section>
        <header class="mb-3">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Check updated fields') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __("Check and confirm the import updates.") }}
            </p>
        </header>


        @if(!empty($newMembers))
            <div x-data="{open:true}" class="bg-gray-50">
                <div class="flex justify-between items-center bg-gray-200">
                    <p class="px-4">{{__("New members")}}</p>
                    <button @click="open=!open" x-html="open ? '-' :'+' "
                            class="px-2 text-black hover:text-gray-500 font-bold text-3xl"></button>
                </div>
                <div x-show="open" x-cloak class="mx-4 py-4" x-transition>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 text-xs break-words">
                        @foreach($newMembers as $importedMember)
                            <ul class="border-2 bg-white p-3">
                                @foreach($importedMember as $key => $value)
                                    <li><strong>
                                            {{__(\App\Models\Import\ImportedMember::ATTRIBUTE_LABEL_ARRAY[$key])}}:
                                        </strong> {{$value}}</li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
                <hr class="h-[0.1rem] bg-slate-500">
            </div>
        @endif

        @if(!empty($changedMembers))
            <div x-data="{open:true}" class="bg-gray-50">
                <div class="flex justify-between items-center bg-gray-200">
                    <p class="px-4">{{__("Members with updates")}}</p>
                    <button @click="open=!open" x-html="open ? '-' :'+' "
                            class="px-2 text-black hover:text-gray-500 font-bold text-3xl"></button>
                </div>
                <div x-show="open" x-cloak class="mx-4 py-4" x-transition>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 text-xs break-all">
                        @foreach($changedMembers as $wrapper)
                            <div class="border-2 bg-white p-3 text-xs">
                                @php
                                    /** @var \App\Models\Import\MemberChangesWrapper $wrapper */
                                @endphp
                                <div class="text-base mb-2">{{$wrapper->original->id}}
                                    - {{$wrapper->original->getFullName()}}</div>
                                <table class="border-2 w-full">
                                    @foreach($wrapper->attributeDifferenceList as $attributeName)
                                        <tr class="border-2">
                                            <td class="border-2 font-bold">{{__(\App\Models\Import\ImportedMember::ATTRIBUTE_LABEL_ARRAY[$attributeName])}}</td>
                                            <td class="text-green-700">{{$wrapper->original->getAttributeValue($attributeName)}}</td>
                                            <td class="text-orange-600">{{$wrapper->imported->getAttribute($attributeName)}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
                <hr class="h-[0.1rem] bg-slate-500">
            </div>
        @endif



        @if(!empty($unchangedImports))
            <div x-data="{open:true}" class="bg-gray-50">
                <div class="flex justify-between items-center bg-gray-200">
                    <p class="px-4">{{__("Unchanged members")}}</p>
                    <button @click="open=!open" x-html="open ? '-' :'+' "
                            class="px-2 text-black hover:text-gray-500 font-bold text-3xl"></button>
                </div>
                <div x-show="open" x-cloak class="mx-4 py-4" x-transition>
                    <ul class="white list-disc ml-5">
                        @foreach($unchangedImports as $importedMember)
                            <li>{{$importedMember->getAttribute('lastname')}}
                                {{$importedMember->getAttribute('firstname')}}</li>
                        @endforeach
                    </ul>
                </div>
                <hr class="h-[0.1rem] bg-slate-500">
            </div>
        @endif




        @if(!empty($newMembers) || !empty($changedMembers))
            <div class="flex flex-row-reverse mt-5">
                <x-default-button class="btn-danger" wire:click="syncMembers"
                                  title="Import members">{{ __('Import members') }}</x-default-button>
            </div>
        @else
            <div class="flex justify-center mt-5">
                <p class="text-sm text-gray-600">
                    {{__("Nothing to import.")}}
                </p>
            </div>
        @endif
    </section>
</div>
