<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Create new event") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex justify-end gap-2 items-center">
        <x-default-button class="btn-primary" wire:click="savePoll"
                          title="Create new attendance poll">{{ __('Save') }}</x-default-button>
    </div>


    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
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
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                      wire:model.defer="poll.title"
                                      required autofocus autocomplete="title"/>
                        @error('poll.title')
                        <x-input-error class="mt-2" :messages="$message"/>@enderror
                    </div>

                    <div class="my-3">
                        <x-input-label for="description" :value="__('Description')"/>
                        <x-textarea id="description" name="description" class="mt-1 block w-full min-h-[200px]"
                                    wire:model.defer="poll.description" required autocomplete="description"/>
                        @error('poll.description')
                        <x-input-error class="mt-2" :messages="$message"/>@enderror

                    </div>


                    <!-- Enabled -->
                    <div class="mt-4 ml-3">
                        <x-input-checkbox id="enabled" name="enabled" wire:model.defer="poll.enabled"
                                          class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            {{ __('Enabled') }}
                        </x-input-checkbox>
                    </div>

                    <!-- allow_anonymous_vote -->
                    <div class="mt-4 ml-3">
                        <x-input-checkbox id="allow_anonymous_vote" name="allow_anonymous_vote"
                                          wire:model.defer="poll.allow_anonymous_vote"
                                          class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            {{ __('Allow anonymous votes') }}
                        </x-input-checkbox>
                    </div>


                    <div class="mt-4">
                        <x-input-label for="closing_at" :value="__('Closing at')"/>
                        <x-input-datetime id="closing_at" name="closing_at" type="text" class="mt-1 block w-full"
                                          wire:model.defer="closing_at"
                                          required autofocus autocomplete="closing_at"/>
                        @error('closing_at')
                        <x-input-error class="mt-2" :messages="$message"/>@enderror
                    </div>

                </div>
            </section>

        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">

            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Event selection') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Select the events for the attendance poll.") }}
                    </p>
                </header>

                <div class="mt-6 flex justify-center">

                    @forelse(\App\Models\Event::query()->whereIn("id", $eventList)->orderBy("start")->get() as $event)
                        <div>{{$event->start->formatDateOnly()}} - {{$event->title}}</div>
                    @empty
                        <div>no events selected.</div>
                    @endforelse
                </div>


                {{--  poll event selection --}}
                <div class="my-4"
                     x-data="{additionalEventList:[], addEvents() {
                $wire.addEventList(this.additionalEventList);
                this.additionalEventList = [];
            }}">
                    <x-input-label for="eventSelectionList" :value="__('Select an event to add:')"/>
                    <select id="eventSelectionList" name="eventSelectionList" multiple size="5"
                            x-model="additionalEventList"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                        @foreach(\App\Models\Event::getFutureEvents(false, true)->whereNotIn('id', $eventList)->get() as $event)
                            <option value="{{$event->id}}">{{$event->start->formatDateOnly()}}
                                - {{$event->title}}</option>
                        @endforeach
                    </select>
                    <div class="flex justify-center mt-2">
                        <x-default-button type="button" class="btn btn-primary"
                                          x-bind:disabled="additionalEventList.length === 0"
                                          x-on:click="addEvents">Add events to poll
                        </x-default-button>
                    </div>
                </div>
            </section>
        </div>
    </div>

</div>
