
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <span>{{ __('Event Type Overview') }}</span>
            <x-button-link href="{{route('event.type.create')}}" class="btn-success" title="Create new event type">
                {{__("Add new event type")}}
            </x-button-link>
        </div>
    </x-slot>


    <div class="flex flex-col gap-3 bg-white shadow-sm sm:rounded-lg p-6 text-gray-900">
        <div class="mx-auto">
        @foreach(\App\Models\EventType::getTopLevelQuery()->get() as $child)
            <x-events.event-type-list-item :eventType="$child" class="my-2"/>
        @endforeach
        </div>
    </div>

</x-backend-layout>
