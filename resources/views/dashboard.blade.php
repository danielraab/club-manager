<x-backend-layout>
    <x-slot name="headline">
        <span>{{ __('Dashboard') }}</span>
    </x-slot>
    <x-slot name="headerBtn">
        <x-web-push-notification-icon/>
    </x-slot>

    <div class="flex flex-col md:flex-row gap-4">
        <x-dashboard.members/>
        <x-dashboard.polls/>
        <x-dashboard.sponsoring/>
    </div>
    <x-dashboard.lastBirthdays/>
    <div class="flex flex-col-reverse lg:grid lg:grid-cols-2 gap-4">
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-dashboard.eventList :eventList="$eventList"/>
            <div class="flex flex-row items-center justify-around my-3">
                <a href="{{route('event.calendar')}}" class="btn btn-info max-md:hidden" title="Calendar">
                    <i class="fa-solid fa-calendar-days mr-1"></i>
                    {{__("Calendar")}}
                </a>
                <div class="cursor-pointer text-center my-2"
                     title="{{__("Link for calendar abo. Click to copy to clipboard.")}}"
                     x-data="{
                         showMessage:false,
                         copyToClipboard() {
                            navigator.clipboard.writeText('{{route("event.iCalendar")}}');
                            $store.notificationMessages.addNotificationMessages([{
                                message: '{{__("Calender link is now in your clipboard. Paste it wherever you want")}}'
                            }]);
                         }}"
                     @click="copyToClipboard()">
                    <i class="fa-solid fa-calendar"></i>
                    <span>{{route("event.iCalendar")}}</span>
                </div>
            </div>
            @if(\Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Event::EVENT_EDIT_PERMISSION))
                <div class="text-center mt-3">
                    <a href="{{route('event.create')}}" class="btn btn-create" title="Create new event">
                        <i class="fa-solid fa-plus mr-1"></i>
                        {{__("Create new event")}}
                    </a>
                </div>
            @endif
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-dashboard.newsList :newsList="$newsList"/>

            @if(\Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\News::NEWS_EDIT_PERMISSION))
                <div class="text-center mt-3">
                    <a href="{{route('news.create')}}" class="btn btn-create" title="Create new news">
                        <i class="fa-solid fa-plus mr-1"></i>
                        {{__("Create new news")}}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-backend-layout>
