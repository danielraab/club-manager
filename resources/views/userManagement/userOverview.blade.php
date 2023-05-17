@php
$hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\UserPermission::USER_MANAGEMENT_EDIT);
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <span>{{ __('User Overview') }}</span>
            @if($hasEditPermission)
            <x-button-link href="{{route('userManagement.create')}}" class="btn-success">
                Add new user
            </x-button-link>
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
                <td class="px-4 py-2">Permissions</td>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="[&:nth-child(2)]:bg-neutral-100">
                    <td class="border px-4 py-2">{{$user->id}}</td>
                    <td class="border px-4 py-2">{{ $user->name }}</td>
                    <td class="border px-4 py-2">{{ $user->email }}</td>
                    <td class="border px-4 py-2">
                        <ul class="list-disc text-left pl-3">
                            @foreach($user->userPermissions()->get() as $permission)
                                <li>{{$permission->id}}</li>
                            @endforeach
                        </ul>
                    </td>
                    @if($hasEditPermission)
                    <td class="border">
                        <x-button-link href="{{route('userManagement.edit', $user->id)}}" class="mx-2 bg-gray-800 text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </x-button-link>
                    </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </x-always-responsive-table>
    </div>
</x-backend-layout>
