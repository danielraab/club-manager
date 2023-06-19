
<div class="bg-white shadow-sm sm:rounded-lg p-4">
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Member group') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __("Enter basic information for the member group.") }}
            </p>
        </header>

        <div class="mt-6">
            <div>
                <x-input-label for="title" :value="__('Title')"/>
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                              wire:model.defer="memberGroup.title"
                              required autofocus autocomplete="title"/>
                @error('memberGroup.title')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
        </div>

        <div class="my-3">
            <x-input-label for="description" :value="__('Description')"/>
            <x-textarea id="description" name="description" class="mt-1 block w-full min-h-[100px]"
                        wire:model.defer="memberGroup.description" required autocomplete="description"/>
            @error('memberGroup.description')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        {{--        member group--}}
        <div>
            <x-input-label for="memberGroup" :value="__('Parent member group')"/>
            <select id="parent" name="parent"
                    wire:model.lazy="parent"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                <option value=""></option>
                @foreach(\App\Models\MemberGroup::getTopLevelQuery()->get() as $topLevelMemberGroup)
                    <x-members.member-group-select-option :memberGroup="$topLevelMemberGroup" :currentEditingMemberGroup="$memberGroup" />
                @endforeach
            </select>
            @error('parent')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

    </section>
</div>
