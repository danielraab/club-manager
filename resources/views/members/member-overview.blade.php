@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Member::MEMBER_EDIT_PERMISSION);
@endphp
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <span>{{ __('Member Overview') }}</span>
            @if($hasEditPermission)
                <div class="flex flex-wrap justify-end gap-2 w-full sm:w-auto">
                    <x-button-link href="{{route('member.group.index')}}" class="btn-secondary"
                                   title="Show member group list">
                        {{__("Member Group List")}}
                    </x-button-link>
                    <x-button-link href="{{route('member.create')}}" class="btn-success" title="Create new member">
                        {{__("Add new member")}}
                    </x-button-link>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
        <x-always-responsive-table class="table-auto mx-auto text-center">
            <thead class="font-bold">
            <tr>
                <td class="px-4 py-2">Name</td>
                <td class="px-4 py-2">{{__("Birthday")}}</td>
                <td class="px-4 py-2">eMail</td>
                <td class="px-4 py-2">{{__("Phone")}}</td>
                <td class="px-4 py-2">{{__("Member Groups")}}</td>
            </tr>
            </thead>
            <tbody>
            @foreach($members as $member)
                <tr class="[&:nth-child(2n)]:bg-indigo-200">
                    <td class="border px-4 py-2">{{ $member->lastname }} {{ $member->firstname }}</td>
                    <td class="border px-4 py-2">{{ $member->birthday }}</td>
                    <td class="border px-4 py-2">{{ $member->email }}</td>
                    <td class="border px-4 py-2">{{ $member->phone }}</td>
                    <td class="border px-4 py-2">
                        <ul class="list-disc text-left pl-3">
                            @foreach($member->memberGroups()->get() as $memberGroup)
                                <li title="{{$memberGroup->title}}">{{$memberGroup->title}}</li>
                            @endforeach
                        </ul>
                    </td>
                    @if($hasEditPermission)
                        <td class="border">
                            <x-button-link href="{{route('member.edit', $member->id)}}" title="Edit member"
                                           class="mx-2 bg-gray-800 text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
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
