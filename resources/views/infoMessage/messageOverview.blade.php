@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\InfoMessage::INFO_MESSAGE_EDIT_PERMISSION);
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <span>{{ __('Info Message Overview') }}</span>
            @if($hasEditPermission)
                <x-button-link href="{{route('infoMessage.create')}}" class="btn-success" title="Create new info message">
                    {{__("Add new message")}}
                </x-button-link>
            @endif
        </div>
    </x-slot>

    <div class="flex justify-center mb-3">
        {!! $messages->links('components.paginator') !!}
    </div>

    <div class="flex flex-col gap-3 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
        @foreach($messages as $message)
            <div
                class="max-w-full border border-gray-400 rounded p-4 flex flex-col justify-between leading-normal bg-sky-100">
                <div class="mb-5">
                    <div class="text-gray-900 font-bold text-xl mb-2 flex items-top justify-between">
                        <span>{{ $message->title }}</span>
                        <div class="flex items-center ml-3">
                            @if($message->onlyInternal)
                                <i class="fa-solid fa-arrow-right-to-bracket text-sm text-gray-600 mr-2" title="{{__("Visible only for logged in users")}}"></i>
                            @endif
                            @if(!$message->enabled)
                                <x-dot class=" bg-rose-400" title="{{__("Message disabled")}}"/>
                            @elseif($message->onDashboardUntil < now())
                                <x-dot class=" bg-gray-400" title="{{__("Message retired")}}"/>
                            @else
                                <x-dot class="bg-green-500" title="{{__("Message active")}}"/>
                            @endif
                        </div>
                    </div>
                    <p class="text-gray-700 text-base">
                        {{ strlen($message->content) > 200 ? substr($message->content, 0,150) . " ..." : $message->content }}
                    </p>
                </div>
                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        @if($message->lastUpdater)
                            <p class="text-gray-900 leading-none">
                                <span title="{{__("Last updater")}}"><i class="fa-solid fa-pencil"></i> {{ $message->lastUpdater->name }}</span>
                            </p>
                        @endif
                        <p class="text-gray-600">
                            <span title="{{__("Last updated")}}"><i class="fa-regular fa-calendar-plus"></i> {{$message->updated_at->isoFormat('D. MMM YYYY')}}</span>
                            @if($message->onDashboardUntil)
                                <span title="{{__("Displayed on dashboard until")}}"><i class="fa-regular fa-clock ml-3"></i> {{$message->onDashboardUntil?->isoFormat('D. MMM YYYY')}}</span>
                            @endif
                        </p>
                    </div>
                    @if($hasEditPermission)
                        <x-button-link href="{{route('infoMessage.edit', $message->id)}}" title="Edit this message"
                                       class="mx-2 bg-gray-800 text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </x-button-link>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="flex justify-center mt-3">
        {!! $messages->links('components.paginator') !!}
    </div>
</x-backend-layout>
