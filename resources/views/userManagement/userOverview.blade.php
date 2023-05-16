<x-backend-layout>
    <x-slot name="headline">
        {{ __('User Overview') }}
    </x-slot>

    <div class="p-6 text-gray-900">
        <table class="table-auto mx-auto text-center">
            <thead class="font-medium font-bold">
            <tr>
                <td class="px-4 py-2">Name</td>
                <td class="px-4 py-2">eMail</td>
                <td class="px-4 py-2">Permissions</td>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="[&:nth-child(2)]:bg-neutral-100">
                    <td class="border px-4 py-2">{{ $user->name }}</td>
                    <td class="border px-4 py-2">{{ $user->email }}</td>
                    <td class="border px-4 py-2">
                        @foreach($user->userPermissions()->get() as $permission)
                        <p>{{var_dump($permission)}}</p>
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-backend-layout>
