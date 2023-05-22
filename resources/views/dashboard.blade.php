<x-backend-layout>
    <x-slot name="headline">
        {{ __('Dashboard') }}
    </x-slot>


    <div class="flex flex-col-reverse lg:grid lg:grid-cols-2 gap-4">
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            @foreach($eventList as $event)
                <div>{{$event->title}} - todo</div>
            @endforeach
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <x-dashboard.newsList :newsList="$newsList"/>
        </div>

    </div>
</x-backend-layout>
