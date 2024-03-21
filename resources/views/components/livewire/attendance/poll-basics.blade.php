<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Poll basics') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Enter title and short description for the poll.") }}
        </p>
    </header>

    <div class="mt-6">
        <div>
            <x-input-label for="title" :value="__('Title')"/>
            <x-input id="title" name="title" type="text" class="mt-1 block w-full"
                          wire:model="pollForm.title"
                          required autofocus autocomplete="title"/>
            @error('pollForm.title')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        <div class="my-3">
            <x-input-label for="description" :value="__('Description')"/>
            <x-textarea id="description" name="description" class="mt-1 block w-full min-h-[200px]"
                        wire:model="pollForm.description" required autocomplete="description"/>
            @error('pollForm.description')
            <x-input-error class="mt-2" :messages="$message"/>@enderror

        </div>


        <!-- allow_anonymous_vote -->
        <div class="mt-4 ml-3">
            <x-input-checkbox id="allow_anonymous_vote" name="allow_anonymous_vote"
                              wire:model="pollForm.allow_anonymous_vote"
                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                {{ __('Allow anonymous votes') }}
            </x-input-checkbox>
        </div>


        <div class="mt-4">
            <x-input-label for="closing_at" :value="__('Closing at')"/>
            <x-input type="datetime-local" id="closing_at" name="closing_at" class="mt-1 block w-full"
                              wire:model="pollForm.closing_at"
                              required autofocus autocomplete="closing_at"/>
            @error('pollForm.closing_at')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>


        {{--        member group--}}
        <div class="mt-4">
            <x-input-label for="memberGroup" :value="__('Member group')"/>
            <x-select id="memberGroup" name="memberGroup"
                    wire:model.lazy="pollForm.memberGroup"
                    class="block mt-1 w-full">
                <option value=""></option>
                @foreach(\App\Models\MemberGroup::getTopLevelQuery()->get() as $topLevelMemberGroup)
                    <x-members.member-group-select-option :memberGroup="$topLevelMemberGroup" />
                @endforeach
            </x-select>
            @error('pollForm.memberGroup')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>
    </div>
</section>
