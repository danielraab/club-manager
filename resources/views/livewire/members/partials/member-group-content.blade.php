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
                <x-input id="title" name="title" type="text" class="mt-1 block w-full"
                         wire:model="memberGroupForm.title"
                         required autofocus autocomplete="title"/>
                @error('memberGroupForm.title')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
        </div>

        <div class="my-3">
            <x-input.textarea
                id="description"
                autocomplete="description"
                :label="__('Description')"
                class="w-full min-h-[100px]"
                wire:model="memberGroupForm.description"
                errorBag="memberGroupForm.description"
            />
        </div>

        <div class="flex gap-2 mt-3">
            {{--        member group--}}
            <div class="basis-3/4">
                <x-input-label for="memberGroup" :value="__('Parent member group')"/>
                <x-select id="parent" name="parent"
                          wire:model.blur="memberGroupForm.parent"
                          class="block mt-1 w-full">
                    <option value=""></option>
                    @foreach(\App\Models\MemberGroup::getTopLevelQuery()->get() as $topLevelMemberGroup)
                        <x-members.member-group-select-option :memberGroup="$topLevelMemberGroup"
                                                              :currentEditingMemberGroup="$memberGroupForm->memberGroup"/>
                    @endforeach
                </x-select>
                @error('memberGroupForm.parent')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>

            <div class="basis-1/4">
                <x-input-label for="sort_order" :value="__('Sort order')"/>
                <x-input id="sort_order" name="sort_order" type="number" class="mt-1 block w-full"
                         wire:model="memberGroupForm.sort_order"
                         required autofocus autocomplete="sort_order"/>
                @error('memberGroupForm.sort_order')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
        </div>
    </section>
</div>
