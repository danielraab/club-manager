@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\UserPermission::USER_MANAGEMENT_EDIT_PERMISSION);
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <span>{{ __('User Overview') }}</span>
            @if($hasEditPermission)
                <a href="{{route('userManagement.create')}}" class="btn btn-success" title="Create new user">
                    {{__("Add new user")}}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
        <x-always-responsive-table class="table-auto mx-auto text-center">
            <thead class="font-bold">
            <tr>
                <td class="px-4 py-2">Id</td>
                <td class="px-4 py-2">Name</td>
                <td class="px-4 py-2">eMail</td>
                <td class="px-4 py-2">{{__("Permissions")}}</td>
                <td class="px-4 py-2">{{__("Last login")}}</td>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="[&:nth-child(2n)]:bg-indigo-200">
                    <td class="border px-4 py-2">{{$user->id}}</td>
                    <td class="border px-4 py-2">{{ $user->name }}</td>
                    <td class="border px-4 py-2">{{ $user->email }}</td>
                    <td class="border px-4 py-2">
                        <ul class="list-disc text-left pl-3">
                            @foreach($user->userPermissions()->orderBy('id')->get() as $permission)
                                <li title="{{$permission->label}}">{{$permission->id}}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="border px-4 py-2">{{$user->last_login_at?->formatDateTimeWithSec()}}</td>
                    @if($hasEditPermission)
                        <td class="border">
                            <a href="{{route('userManagement.edit', $user->id)}}" title="Edit user"
                                           class="btn btn-edit">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </x-always-responsive-table>
    </div>
</x-backend-layout>
