@php
    $hasShowPermission = (bool) \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Member::MEMBER_SHOW_PERMISSION);
    $showBirthdayListConfig = \App\Models\Configuration::getBool(\App\Models\ConfigurationKey::DASHBOARD_BTN_BIRTHDAY_LIST, auth()->user(), true);
    $hasImportPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Import\ImportedMember::MEMBER_IMPORT_PERMISSION);
    $showMemberImportConfig = \App\Models\Configuration::getBool(\App\Models\ConfigurationKey::DASHBOARD_BTN_IMPORT_MEMBERS, auth()->user(), false);
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <span>{{ __('Dashboard') }}</span>
            <div>
                @if($hasShowPermission && $showBirthdayListConfig)
                    <x-button-link class="btn-secondary"
                                   href="{{route('member.birthdayList')}}"
                                   title="Show list of member birthdays">{{ __('Birthday list') }}</x-button-link>
                @endif
                @if($hasImportPermission && $showMemberImportConfig)
                    <x-button-link class="btn-info"
                                   href="{{route('member.import')}}"
                                   title="Import member list">{{__("Import members")}}</x-button-link>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col-reverse lg:grid lg:grid-cols-2 gap-4">
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-dashboard.eventList :eventList="$eventList"/>
            <div class="flex flex-row items-center justify-around mt-3">
                <x-button-link href="{{route('event.calendar')}}" class="btn-success max-md:hidden" title="Calendar">
                    <i class="fa-solid fa-calendar-days mr-1"></i>
                    {{__("Calendar")}}
                </x-button-link>
                <div class="cursor-pointer text-center my-2"
                     title="{{__("Link for calendar abo. Click to copy to clipboard.")}}"
                     x-data="{
                         showMessage:false,
                         copyToClipboard() {
                            navigator.clipboard.writeText('{{route("event.iCalendar")}}');
                            this.showMessage=true;
                            setTimeout(()=>this.showMessage=false, 5000);
                         }}"
                     @click="copyToClipboard()">
                    <i class="fa-solid fa-calendar"></i>
                    <span>{{route("event.iCalendar")}}</span>
                    <p x-cloak x-show="showMessage" class="text-gray-700">Copied</p>
                </div>
            </div>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-dashboard.newsList :newsList="$newsList"/>
        </div>

    </div>
</x-backend-layout>
