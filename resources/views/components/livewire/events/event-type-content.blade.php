
<div class="bg-white shadow-sm sm:rounded-lg p-4">
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Event type') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __("Enter basic information for the event type.") }}
            </p>
        </header>

        <div class="mt-6">
            <div>
                <x-input-label for="title" :value="__('Title')"/>
                <x-input id="title" name="title" type="text" class="mt-1 block w-full"
                              wire:model="eventTypeForm.title"
                              required autofocus autocomplete="title"/>
                @error('eventTypeForm.title')
                <x-input-error class="mt-2" :messages="$message"/>@enderror
            </div>
        </div>

        <div class="my-3">
            <x-input-label for="description" :value="__('Description')"/>
            <x-textarea id="description" name="description" class="mt-1 block w-full min-h-[100px]"
                        wire:model="eventTypeForm.description" required autocomplete="description"/>
            @error('eventTypeForm.description')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

        {{--        event type--}}
        <div>
            <x-input-label for="eventType" :value="__('Parent event type')"/>
            <x-select id="parent" name="parent"
                    wire:model="eventTypeForm.parent"
                    class="block mt-1 w-full">
                <option value=""></option>
                @foreach(\App\Models\EventType::getTopLevelQuery()->get() as $eventTypeTreeElem)
                    <x-events.event-type-select-option :eventType="$eventTypeTreeElem" :currentEditingEventTypeForm="$eventTypeForm" />
                @endforeach
            </x-select>
            @error('eventTypeForm.parent')
            <x-input-error class="mt-2" :messages="$message"/>@enderror
        </div>

    </section>
</div>
