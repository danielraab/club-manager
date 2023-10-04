<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Entrance and member group') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Enter information about entrance and association to member groups.") }}
        </p>
    </header>

    <div class="mt-6">

        {{-- entrance_date --}}
        <div class="mt-4">
            <x-input-label for="entrance_date" :value="__('Entrance date')"/>
            <x-input-date id="entrance_date" name="entrance_date" type="text" class="mt-1 block w-full"
                              wire:model.blur="entrance_date"
                          autofocus autocomplete="entrance_date"/>
            @error('entrance_date')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        {{-- leaving_date --}}
        <div class="mt-4">
            <x-input-label for="leaving_date">
                <span>{{__('Leaving date')}}</span>
                <i class="fa-solid fa-circle-info text-gray-500 ml-2" title="{{__("The Member is special marked after the leaving date is reached. And will not appear in export etc.")}}"></i>
            </x-input-label>
            <x-input-date id="leaving_date" name="leaving_date" type="text" class="mt-1 block w-full"
                              wire:model.blur="leaving_date"
                          autofocus autocomplete="leaving_date"/>

            @error('leaving_date')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <!-- is paused -->
        <div class="mt-5 mb-4 ml-3">
            <x-input-checkbox id="paused" name="paused" wire:model="member.paused"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Is paused') }} <i class="fa-solid fa-circle-info text-gray-500 ml-2"
                                         title="{{__("The membership is paused.")}}"></i>
            </x-input-checkbox>
        </div>

        <div class="mt-5 mb-6">
            <x-input-label for="memberGroupList" :value="__('Member groups')"/>
            <select name="memberGroupList" id="memberGroupList" size="10" multiple
                    wire:model="memberGroupList"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
            >
                @foreach(\App\Models\MemberGroup::getLeafQuery()->get() as $memberGroup)
                    <option value="{{$memberGroup->id}}">{{$memberGroup->title}}</option>
                @endforeach
            </select>
            @error('memberGroupList')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>


        @if($member && ($member->external_id || $member->last_import_date))
            <div class="text-gray-500 mt-2 ml-3">
                <i class="fa-solid fa-up-right-from-square"></i>
                <span title="{{__("External id")}}">{{$member->external_id}}</span> -
                <span title="{{__("Last import")}}">{{$member->last_import_date}}</span>
            </div>
        @endif

        @if($member && $member->created_at)
            <div class="text-gray-500 mt-2 ml-3">
                <i class="fa-regular fa-square-plus"></i>
                <span title="{{__("Creator")}}">{{$member->creator?->name}}</span> -
                <span title="{{__("Created at")}}">{{$member->created_at->formatDateTimeWithSec()}}</span>
            </div>
        @endif

        @if($member && $member->updated_at)
            <div class="text-gray-500 mt-2 ml-3">
                <i class="fa-solid fa-pencil"></i>
                <span title="{{__("Last updater")}}">{{ $member->lastUpdater?->name }}</span> -
                <span title="{{__("Updated at")}}">{{$member->updated_at->formatDateTimeWithSec()}}</span>
            </div>
        @endif
    </div>
</section>
