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

        <div>
            @foreach($keyedData as $member)
                <div>
                @foreach($member as $key => $value)
                    <span>{{$key}}</span>
                    <span>{{$value}}</span>
                @endforeach
                </div>
            @endforeach
        </div>

        <div class="flex flex-row-reverse mt-5">
            <x-default-button class="btn-danger" wire:click="syncMembers"
                              title="Sync members">{{ __('Sync members') }}</x-default-button>
        </div>
    </section>
</div>
