<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Event-Settings') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Show and edit user global event settings.') }}
        </p>
    </header>

    <x-livewire.loading/>
    <div
        class="m-3 rounded-md bg-white p-4 text-[0.8125rem] leading-6 text-slate-900 shadow-xl shadow-black/5 ring-1 ring-slate-700/10">
        <div class="font-semibold leading-5">{{__("List Filter")}}</div>
        <div class="mt-2 mb-4 leading-5 text-slate-500">{{__("Default settings for list filters.")}}</div>
        <div class="flex items-center justify-between border-t border-slate-400/20 py-3">
            <span>{{__("Start date")}}</span>
            <div class="flex flex-col justify-end gap-2 items-center"
                 x-data="{
                    enabled:false,
                    switchChanged(curState) {
                        this.enabled = curState
                        $wire.set('eventStartToday', curState);
                    }
                }" x-init="enabled={{$eventStartToday ? 'true' : 'false'}}">
                <x-input-date wire:model.live="eventStartDate" x-bind:disabled="enabled"/>
                <div class="flex items-center gap-3">
                    <span>{{__("Today")}}</span>
                    <x-input-switch/>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-between border-t border-slate-400/20 py-3">
            <span>{{__("End date")}}</span>
            <x-input-date wire:model.live="eventEndDate"/>
        </div>
    </div>
</section>
