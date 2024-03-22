<?php
/** @var \App\Models\Event $event */

$hasEventEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Event::EVENT_EDIT_PERMISSION) ?? false;
?>
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex gap-3 items-center">
            <span>{{ __('Calendar') }}</span>
        </div>
    </x-slot>

    <div class="flex justify-center">
        <div class="flex flex-col gap-3 bg-white shadow-sm sm:rounded-lg p-6 text-gray-900 w-full justify-center">
            @vite(['resources/js/fullCalendar.js'])
            <script>

                document.addEventListener('DOMContentLoaded', function () {
                    let calendar = new document.Calendar(document.getElementById("calendar"), {
                        plugins: [document.dayGridPlugin, document.timeGridPlugin, document.listPlugin],
                        locales: [document.deLocale],
                        initialView: 'dayGridMonth',
                        locale: '{{config("app.locale")}}',
                        headerToolbar: {
                            left: 'prev,next today',
                            center: '',
                            right: 'title'
                        },
                        events: JSON.parse('{!! $jsonEventList!!}'),
                        eventClick: function(info) {
                            eventInfoText = 'Event: ' + info.event.title +'\n';

                            eventInfoText += '\nStart: ' + info.event.start;
                            if(info.event.end)
                                eventInfoText += '\nEnd: ' + info.event.end;
                            if(info.event.extendedProps.description)
                                eventInfoText += '\nDescription: ' + info.event.extendedProps.description;
                            if(info.event.extendedProps.location)
                                eventInfoText += '\nLocation: ' + info.event.extendedProps.location;
                            if(info.event.extendedProps.dress_code)
                                eventInfoText += '\nDress code: ' + info.event.extendedProps.dress_code;
                            if(info.event.extendedProps.link)
                                eventInfoText += '\nLink: ' + info.event.extendedProps.link;

                            alert(eventInfoText);
                        }
                    });
                    calendar.render();
                });

            </script>
            <div id="calendar" class="max-sm:text-xs"></div>
        </div>
    </div>
</x-backend-layout>
