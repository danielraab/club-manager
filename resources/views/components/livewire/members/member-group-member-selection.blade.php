<div class="bg-white shadow-sm sm:rounded-lg p-4">
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Members') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __("Select the associated members.") }}
            </p>
        </header>

        <div class="mt-6">
            <div>
                <x-input-label for="members" :value="__('Members')"/>
                <select name="members" id="members" size="10" multiple
                        wire:model.defer="memberSelection"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                >
                    @foreach(\App\Models\Member::allActive()->get() as $member)
                        <option value="{{$member->id}}">{{$member->lastname}} {{$member->firstname}}</option>
                    @endforeach
                </select>
                @error('memberSelection')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
        </div>

    </section>
</div>
