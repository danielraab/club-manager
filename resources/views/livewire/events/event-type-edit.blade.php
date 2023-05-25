<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Update event type") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex items-center justify-between">
            <x-default-button
                x-data="{ clickCnt: 0, onClick() {
                if(this.clickCnt > 0) {
                    $wire.deleteEventType();
                } else {
                    this.clickCnt++;
                    $el.innerHTML = 'Are you sure?';
                }
            }}"
                x-on:click="onClick()" title="Delete this event type"
                class="btn-danger">{{ __('Delete event type') }}</x-default-button>
            <x-default-button class="btn-primary" wire:click="saveEventType"
                              title="Create new event type">{{ __('Save') }}</x-default-button>
        </div>
    </div>


    <div class="flex justify-center">

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
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                      wire:model.defer="eventType.title"
                                      required autofocus autocomplete="title"/>
                        @error('eventType.title')
                        <x-input-error class="mt-2" :messages="$message"/>@enderror
                    </div>
                </div>

                <div class="my-3">
                    <x-input-label for="description" :value="__('Description')"/>
                    <x-textarea id="description" name="description" class="mt-1 block w-full min-h-[100px]"
                                wire:model.defer="eventType.description" required autocomplete="description"/>
                    @error('eventType.description')
                    <x-input-error class="mt-2" :messages="$message"/>@enderror
                </div>

                {{--        event type--}}
                <div>
                    <x-input-label for="eventType" :value="__('Parent Event Type')"/>
                    <select id="parent" name="parent"
                            wire:model.defer="parent"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                        <option value=""></option>
                        @foreach(\App\Models\EventType::query()->whereNull("parent_id")->get() as $eventTypeTreeElem)
                            <x-events.event-type-select-option :eventType="$eventTypeTreeElem"
                                                               :currentEditingEventType="$eventType"/>
                        @endforeach
                    </select>
                    @error('parent')
                    <x-input-error class="mt-2" :messages="$message"/>@enderror
                </div>

            </section>
        </div>
    </div>

</div>
