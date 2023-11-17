<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Calendar Links') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Generate user specific calendar links. Link will contain logged in only events and member birthdays if you have the permission.') }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        @foreach($tokenLinks as $tokenLink)
            @php
                /** @var \Laravel\Sanctum\PersonalAccessToken $tokenLink */
            @endphp
            <div class="flex w-full items-center gap-3 justify-between"
                 x-data="{
                            showMessage:false,
                            copyToClipboard() {
                                navigator.clipboard.writeText('{{route("event.iCalendar",['t'=>$tokenLink->token])}}');
                                this.showMessage=true;
                                setTimeout(()=>this.showMessage=false, 5000);
                            }}">
                <i class="fa-solid fa-calendar"></i>
                <div>
                    <span class="break-all cursor-pointer"
                          @click="copyToClipboard()">
                        {{route("event.iCalendar",['t'=>$tokenLink->token])}}
                    </span>
                    <p x-cloak x-show="showMessage" class="text-gray-700 text-center">Copied</p>
                </div>
                <x-default-button class="btn btn-danger inline-flex" wire:click="deleteLink({{$tokenLink->id}})"
                                  title="Delete calendar link">x
                </x-default-button>
            </div>
        @endforeach
        <x-default-button class="btn btn-primary inline-flex" wire:click="createLink"
                          title="Create new calendar link">{{ __('New') }}</x-default-button>
    </div>
</section>
