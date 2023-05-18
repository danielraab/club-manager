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

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
        @foreach($messages as $message)
            <div class="flex">
                <div
                    class="m-1 border border-gray-400 bg-white rounded p-4 flex flex-col justify-between leading-normal">
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
                            <p class="text-gray-900 leading-none">{{ $message->lastUpdater?->name }}</p>
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
            </div>
        @endforeach
        {{--        <x-always-responsive-table class="table-auto mx-auto text-center">--}}
        {{--            <thead class="font-bold">--}}
        {{--            <tr>--}}
        {{--                <td class="px-4 py-2">Id</td>--}}
        {{--                <td class="px-4 py-2">Name</td>--}}
        {{--                <td class="px-4 py-2">eMail</td>--}}
        {{--                <td class="px-4 py-2">Permissions</td>--}}
        {{--            </tr>--}}
        {{--            </thead>--}}
        {{--            <tbody>--}}
        {{--            @foreach($users as $user)--}}
        {{--                <tr class="[&:nth-child(2)]:bg-neutral-100">--}}
        {{--                    <td class="border px-4 py-2">{{$user->id}}</td>--}}
        {{--                    <td class="border px-4 py-2">{{ $user->name }}</td>--}}
        {{--                    <td class="border px-4 py-2">{{ $user->email }}</td>--}}
        {{--                    <td class="border px-4 py-2">--}}
        {{--                        <ul class="list-disc text-left pl-3">--}}
        {{--                            @foreach($user->userPermissions()->get() as $permission)--}}
        {{--                                <li>{{$permission->id}}</li>--}}
        {{--                            @endforeach--}}
        {{--                        </ul>--}}
        {{--                    </td>--}}
        {{--                    @if($hasEditPermission)--}}
        {{--                        <td class="border">--}}
        {{--                            <x-button-link href="{{route('userManagement.edit', $user->id)}}"--}}
        {{--                                           class="mx-2 bg-gray-800 text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">--}}
        {{--                                <i class="fa-regular fa-pen-to-square"></i>--}}
        {{--                            </x-button-link>--}}
        {{--                        </td>--}}
        {{--                    @endif--}}
        {{--                </tr>--}}
        {{--            @endforeach--}}
        {{--            </tbody>--}}
        {{--        </x-always-responsive-table>--}}
    </div>
</x-backend-layout>
