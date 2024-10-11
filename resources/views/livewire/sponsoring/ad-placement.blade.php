@php
    /** @var $contract \App\Models\Sponsoring\Contract|null */
@endphp
<x-modal id="adPlacement">
    <div x-init="$store.notificationMessages
            .addNotificationMessages(
            JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))">
    </div>
    <x-livewire.loading />
    <div>
        <div class="w-full p-3 bg-gray-800 text-white max-sm:text-xs">
            {{__("Backer")}}: {{$contract?->backer()->first()->name}}
        </div>
        <div class="w-full p-3 bg-gray-500 text-white max-sm:text-xs">
            {{__("Ad Option")}}: {{$adOption?->title}} ({{$contract?->package()->first()->title}})
        </div>
        <div class="p-5">
            <div>
                <x-input-checkbox id="done" name="done"
                                  wire:model="adPlacementForm.done">
                    {{ __('Done') }}<i class="fa-solid fa-circle-info text-gray-500 ml-2"
                                          title="{{__("Disabled events are not shown on the calendar export neither the json export.")}}"></i>
                </x-input-checkbox>
            </div>
            <div class="mt-3">
                <x-input.textarea
                    id="comment"
                    :label="__('Comment')"
                    class="w-full"
                    wire:model="adPlacementForm.comment"
                    errorBag="adPlacementForm.comment"
                />
            </div>
            <div class="mt-3 flex justify-end">
                <button class="btn btn-primary" type="button"
                        wire:click="save">{{__("Save")}}</button>
            </div>
        </div>
    </div>
</x-modal>
