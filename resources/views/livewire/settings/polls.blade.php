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
        <div class="font-semibold leading-5">{{__("Public poll")}}</div>
        <div class="mt-2 mb-4 leading-5 text-slate-500">{{__("Default settings for public polls.")}}</div>
        @php
        $beforeEntrance = \App\Models\Configuration::getBool(\App\Models\ConfigurationKey::POLL_PUBLIC_FILTER_BEFORE_ENTRANCE);
        $afterRetired = \App\Models\Configuration::getBool(\App\Models\ConfigurationKey::POLL_PUBLIC_FILTER_AFTER_RETIRED);
        $showPaused = \App\Models\Configuration::getBool(\App\Models\ConfigurationKey::POLL_PUBLIC_FILTER_SHOW_PAUSED);
        @endphp
        <div class="flex items-center justify-between border-t border-slate-400/20 py-3"
             x-init="enabled={{$beforeEntrance ? 'true':'false'}}"
             x-data="{enabled:false,
                                    switchChanged(curState) {
                                        this.enabled = curState;
                                        $wire.setBeforeEntrance(curState);
                                    }}">
            <span>{{__("Show members before entrance")}}</span>
            <x-input-switch/>
        </div>
        <div class="flex items-center justify-between border-t border-slate-400/20 py-3"
             x-init="enabled={{$afterRetired ? 'true':'false'}}"
             x-data="{enabled:false,
                                    switchChanged(curState) {
                                        this.enabled = curState;
                                        $wire.setAfterRetired(curState);
                                    }}">
            <span>{{__("Show retired members")}}</span>
            <x-input-switch/>
        </div>
        <div class="flex items-center justify-between border-t border-slate-400/20 py-3"
             x-init="enabled={{$showPaused ? 'true':'false'}}"
             x-data="{enabled:false,
                                    switchChanged(curState) {
                                        this.enabled = curState;
                                        $wire.setShowPaused(curState);
                                    }}">
            <span>{{__("Show paused members")}}</span>
            <x-input-switch/>
        </div>
    </div>
</section>
