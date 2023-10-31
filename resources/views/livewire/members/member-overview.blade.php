@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Member::MEMBER_EDIT_PERMISSION);
    $hasImportPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Import\ImportedMember::MEMBER_IMPORT_PERMISSION);
@endphp

<x-slot name="headline">
    <div class="flex items-center">
        <span>{{ __('Member Overview') }}</span>
    </div>
</x-slot>

<div class="flex flex-col gap-5">
    @if($hasEditPermission)
        <div
            class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5 flex flex-wrap gap-2 w-full sm:w-auto justify-center items-center">
            @if($hasImportPermission)
                <x-button-link href="{{route('member.import')}}" class="btn-info"
                               title="Import member list">
                    {{__("Import members")}}
                </x-button-link>
            @endif
            <div class="flex flex-wrap gap-2 justify-center sm:ml-auto">
                <x-button-link href="{{route('member.group.index')}}" class="btn-secondary"
                               title="Show member group list">
                    {{__("Member Groups")}}
                </x-button-link>
                <x-button-link href="{{route('member.create')}}" class="btn-success" title="Create new member">
                    {{__("Add new member")}}
                </x-button-link>
            </div>
        </div>
    @endif

    <x-livewire.member-filter useMemberGroupFilter/>

    @if($this->members->exists())

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
            <x-livewire.loading/>

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
                @foreach($this->members->get() as $member)
                    @php
                        $rowBg = "bg-lime-200";
                        if($member->entrance_date === null || $member->birthday === null) {
                            $rowBg = "bg-red-200";
                        } elseif($member->entrance_date > now() ||
                         ($member->leaving_date && $member->leaving_date < now())) {
                            $rowBg = "bg-gray-300";
                        } elseif($member->paused) {
                            $rowBg = "bg-sky-200";
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
            <div class="p-2">
                <span>{{__("Members") . ': ' . $this->members->count() }}</span>
            </div>
        </div>


        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
            <div class="flex flex-wrap gap-2 justify-start w-full sm:w-auto">
                <x-button-link class="bg-cyan-700 hover:bg-cyan-500 focus:bg-cyan-500 text-white"
                               href="{{route('member.birthdayList')}}"
                               title="Show list of member birthdays">{{ __('Birthday list') }}</x-button-link>
                <x-button-link class="bg-gray-500 text-white" href="{{route('member.birthdayList.csv')}}"
                               title="Download birthday list as CSV file">{{ __('Birthday CSV') }}</x-button-link>
                <x-button-link class="bg-gray-700 text-white" href="{{route('member.fullBirthdayList.csv')}}"
                               title="Download full birthday list as CSV file. (Incl Paused, retired and coming members)">{{ __('Full Birthday CSV') }}</x-button-link>
            </div>
        </div>

    @else
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 text-center">
            <span>
            {{__("No members to display. Please add a member or import some.")}}
            </span>
        </div>
    @endif
</div>
