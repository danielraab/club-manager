<x-backend-layout>
    <x-slot name="headline">
        <span>{{ __('Event Type Overview') }}</span>
    </x-slot>
{{-- no if because you need edit permission to visit this page. --}}
    <x-slot name="headerBtn">
        <a href="{{route('event.type.create')}}"
           class="btn btn-success max-sm:text-lg gap-2"
           title="Create new event type">
            <i class="fa-solid fa-plus"></i>
            <span class="max-sm:hidden">{{__("Create new event type")}}</span>
        </a>
    </x-slot>


    <div class="flex flex-col gap-3 bg-white shadow-sm sm:rounded-lg p-6 text-gray-900">
        <div class="mx-auto">
            @foreach(\App\Models\EventType::getTopLevelQuery()->get() as $child)
                <x-events.event-type-list-item :eventType="$child" class="my-2"/>
            @endforeach
        </div>
    </div>

</x-backend-layout>
