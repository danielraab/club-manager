@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\InfoMessage::INFO_MESSAGE_EDIT_PERMISSION);
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <span>{{ __('Info Message Overview') }}</span>
            @if($hasEditPermission)
                <x-button-link href="{{route('infoMessage.create')}}" class="btn-success">
                    Add new message
                </x-button-link>
            @endif
        </div>
    </x-slot>

    <div class="flex justify-center mb-3">
        {!! $messages->links('components.paginator') !!}
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">

        @foreach($messages as $message)
            <div
                class="max-w-full m-1 border border-gray-400 bg-white rounded p-4 flex flex-col justify-between leading-normal">
                <div class="mb-5">
                    <div class="text-gray-900 font-bold text-xl mb-2 flex items-top justify-between">
                        <span>{{ $message->title }}</span>
                        @if($message->onlyInternal)
                            <i class="fa-solid fa-lock text-sm text-gray-600 ml-3"></i>
                        @endif
                    </div>
                    <p class="text-gray-700 text-base">
                        {{ strlen($message->content) > 200 ? substr($message->content, 0,150) . " ..." : $message->content }}
                    </p>
                </div>
                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        @if($message->lastUpdater)
                            <p class="text-gray-900 leading-none">
                                <i class="fa-solid fa-pencil"></i> {{ $message->lastUpdater->name }}
                            </p>
                        @endif
                        <p class="text-gray-600">
                            <i class="fa-regular fa-calendar-plus"></i> {{$message->updated_at->isoFormat('D. MMM YYYY')}}
                            @if($message->onDashboardUntil)
                                <i class="fa-regular fa-clock ml-3"></i> {{$message->onDashboardUntil?->isoFormat('D. MMM YYYY')}}
                            @endif
                        </p>
                    </div>
                    @if($hasEditPermission)
                        <x-button-link href="{{route('infoMessage.edit', $message->id)}}"
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
