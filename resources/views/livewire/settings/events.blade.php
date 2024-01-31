<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Event-Settings') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Show and edit user global event settings.') }}
        </p>
    </header>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4 mt-6">
        <div
            class="rounded-md bg-white p-4 text-[0.8125rem] leading-6 text-slate-900 shadow-xl shadow-black/5 ring-1 ring-slate-700/10">
            <div class="font-semibold leading-5">{{__("List Filter")}}</div>
            <div class="mt-2 mb-4 leading-5 text-slate-500">{{__("Default settings for list filters.")}}</div>
            <div class="flex items-center justify-between border-t border-slate-400/20 py-3">
                <span>{{__("Start date")}}</span>
                <x-input-date wire:model.live="eventStartDate"/>
            </div>
            <div class="flex items-center justify-between border-t border-slate-400/20 py-3">
                <span>{{__("End date")}}</span>
                <x-input-date wire:model.live="eventEndDate"/>
            </div>
        </div>
    </div>
</section>
