<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('User Permission') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Select the granted permissions for this user.") }}
        </p>
    </header>

    <div class="mt-6">
        @error('userForm.permissionArr') <x-input-error class="mt-2" :messages="$message"/>@enderror

        <x-always-responsive-table class="table-auto mx-auto text-center">
            <thead class="font-bold">
                <tr>
                    <td></td>
                    <td class="px-4 py-2">{{__("permission")}}</td>
                    <td class="px-4 py-2">{{__("short description")}}</td>
                </tr>
            </thead>
            <tbody>
            @foreach(\App\Models\UserPermission::all() as $permission)
                <tr class="[&:nth-child(2)]:bg-neutral-100">
                    <td class="border px-4 py-2" >
                        <input type="checkbox" data-permission
                               id="{{$permission->id}}"
                               wire:model="userForm.permissionArr.{{$permission->id}}"
                        >
                    </td>
                    <td class="border px-4 py-2" ><label for="{{$permission->id}}">{{$permission->id}}</label></td>
                    <td class="border px-4 py-2">{{$permission->label}}</td>
                </tr>
            @endforeach
            </tbody>
        </x-always-responsive-table>
    </div>
</section>
