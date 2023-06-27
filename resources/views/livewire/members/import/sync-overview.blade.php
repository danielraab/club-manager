<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-5 p-5 ">
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Check updated fields') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __("Check and confirm the import updates.") }}
            </p>
        </header>

        <div x-data="{open:false}" class="w-[60vw] mx-auto bg-red-50">
            <div class="flex justify-between items-center bg-red-200">
                <p class="px-4">New Member</p>
                <button @click="open=!open" x-html="open ? '-' :'+' " class="px-2 text-black hover:text-gray-500 font-bold text-3xl"></button>
            </div>
            <div x-show="open" x-cloak  class="mx-4 py-4" x-transition>
                <div>
                    @foreach($syncMap as $member)
                        <div>
                            @foreach($member as $key => $value)
                                <span>{{$key}}</span>
                                <span>{{$value}}</span>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <hr class="h-[0.1rem] bg-slate-500">
        </div>

        <div class="flex flex-row-reverse mt-5">
            <x-default-button class="btn-danger" wire:click="syncMembers"
                              title="Sync members">{{ __('Sync members') }}</x-default-button>
        </div>
    </section>
</div>
