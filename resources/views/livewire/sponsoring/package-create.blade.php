<x-slot name="headline">
    <div class="flex items-center gap-2">
        <a href="{{route("sponsoring.package.index")}}">
            <i class="fa-solid fa-arrow-left-long"></i>
        </a>
        {{ __("Add new package") }}
    </div>
</x-slot>

<div x-init="$store.notificationMessages
            .addNotificationMessages(
            JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex justify-end gap-2 items-center">
        <button type="button" class="bg-cyan-700 hover:bg-cyan-500 focus:bg-cyan-500 text-white"
                          wire:click="savePackageAndStay"
                          title="Create new package and stay on this site">{{ __('Save and stay') }}</button>
        <button type="button" class="btn btn-primary" wire:click="savePackage"
                          title="Create new package">{{ __('Save') }}</button>
    </div>


    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.sponsoring.package-content/>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-livewire.sponsoring.package-ad-option-selection/>
        </div>
    </div>

</div>
