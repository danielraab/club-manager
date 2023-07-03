@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Member::MEMBER_EDIT_PERMISSION);
    $hasImportPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Import\ImportedMember::MEMBER_IMPORT_PERMISSION);
@endphp

<x-slot name="headline">
    <div class="flex items-center">
        <span>{{ __('Member Overview') }}</span>
    </div>
</x-slot>

<div>
    @if($hasEditPermission)
        <div
            class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5 flex flex-wrap gap-2 w-full sm:w-auto justify-center items-center">
            @if($hasImportPermission)
                <x-button-link href="{{route('member.import')}}" class="btn-info"
                               title="Import member list">
                    {{__("Import members")}}
                </x-button-link>
            @endif
            <div class="flex flex-wrap gap-2 justify-center sm:ml-auto">
                <x-button-link href="{{route('member.group.index')}}" class="btn-secondary"
                               title="Show member group list">
                    {{__("Member Group List")}}
                </x-button-link>
                <x-button-link href="{{route('member.create')}}" class="btn-success" title="Create new member">
                    {{__("Add new member")}}
                </x-button-link>
            </div>
        </div>
    @endif


    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
        <div class="flex flex-wrap gap-5 justify-center text-sm mb-5">
            <div class="flex items-center flex-wrap justify-center">
                <x-input-label for="filterMemberGroup" :value="__('Filter member group:')"/>
                <select name="filterMemberGroup" id="filterMemberGroup" wire:model.lazy="filterMemberGroup"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ml-3 py-1 text-sm"
                >
                    <option></option>
                    @foreach(\App\Models\MemberGroup::getLeafQuery()->get() as $memberGroup)
                        <option value="{{$memberGroup->id}}">{{$memberGroup->title}}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center">
                <x-input-checkbox id="active" name="active" wire:model.lazy="onlyActive"
                                  class="rounded ext-indigo-600 shadow-sm focus:ring-indigo-500">
                    {{ __('active members only') }}
                </x-input-checkbox>
            </div>
        </div>
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
                @php
                    $rowBg = "bg-lime-200";
                    if($member->entrance_date === null || $member->birthday === null) {
                        $rowBg = "bg-red-200";
                    } elseif($member->entrance_date > now() ||
                     ($member->leaving_date && $member->leaving_date < now())) {
                        $rowBg = "bg-gray-300";
                    } elseif($member->special) {
                        $rowBg = "bg-sky-500";
                    }
                @endphp
                <tr class="[&:nth-child(2n)]:bg-opacity-50 {{$rowBg}}">
                    <td class="border px-4 py-2">{{ $member->getFullName() }}</td>
                    <td class="border px-4 py-2">{{ $member->birthday?->format("Y-m-d") }}</td>
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


    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-5 p-5">
        <div class="flex flex-wrap gap-2 justify-start w-full sm:w-auto">
            <x-button-link class="bg-cyan-700 hover:bg-cyan-500 focus:bg-cyan-500 text-white"
                           href="{{route('member.birthdayList')}}"
                           title="Show list of member birthdays">{{ __('Birthday list') }}</x-button-link>
            <x-button-link class="btn-primary normal-case" href="{{route('member.birthdayList.csv')}}"
                           title="Download birthday list as CSV file">{{ __('Birthday CSV') }}</x-button-link>
        </div>
    </div>
</div>
