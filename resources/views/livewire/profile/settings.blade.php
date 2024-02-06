<?php
$hasShowMemberPermission = (bool)\Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Member::MEMBER_SHOW_PERMISSION);
$hasImportMemberPermission = (bool)\Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Import\ImportedMember::MEMBER_IMPORT_PERMISSION);
?>
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Settings') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Show and edit user specific settings.') }}
        </p>
    </header>

    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4 mt-6">
        <div
            class="rounded-md bg-white p-4 text-[0.8125rem] leading-6 text-slate-900 shadow-xl shadow-black/5 ring-1 ring-slate-700/10">
            <div class="font-semibold leading-5">{{__("Dashboard Buttons")}}</div>
            <div class="mt-2 mb-4 leading-5 text-slate-500">{{__("Show or hide buttons on dashboard header.")}}</div>
            @if($hasShowMemberPermission)
                @php($birthdayList = \App\Models\Configuration::getBool(\App\Models\ConfigurationKey::DASHBOARD_BTN_BIRTHDAY_LIST, auth()->user(), true))
                <div class="flex items-center justify-between border-t border-slate-400/20 py-3"
                     x-init="enabled={{$birthdayList ? 'true':'false'}}"
                     x-data="{enabled:false,
                                    switchChanged(curState) {
                                        this.enabled = curState;
                                        $wire.dashboardButtonChangedBirthdayList(curState);
                                    }}">
                    <span>{{__("Birthday list")}}</span>
                    <x-input-switch />
                </div>
            @endif
            @if($hasImportMemberPermission)
                @php($importMembers = \App\Models\Configuration::getBool(\App\Models\ConfigurationKey::DASHBOARD_BTN_IMPORT_MEMBERS, auth()->user(), false))
                <div class="flex items-center justify-between border-t border-slate-400/20 py-3"
                     x-init="enabled={{$importMembers ? 'true':'false'}}"
                     x-data="{enabled:false,
                                    switchChanged(curState) {
                                        this.enabled = curState;
                                        $wire.dashboardButtonChangedImportMembers(curState);
                                    }}">
                    <span>{{__("Import members")}}</span>
                    <x-input-switch />
                </div>
            @endif
        </div>

        <div
            class="rounded-md bg-white p-4 text-[0.8125rem] leading-6 text-slate-900 shadow-xl shadow-black/5 ring-1 ring-slate-700/10">
            <div class="font-semibold leading-5">{{__("Email notifications")}}</div>
            <div
                class="mt-2 mb-4 leading-5 text-slate-500">{{__("Enable or disable email notifications on specific events.")}}</div>
            <div>coming soon</div>
        </div>
    </div>
</section>
