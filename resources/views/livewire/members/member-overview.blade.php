@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Member::MEMBER_EDIT_PERMISSION);
    $hasImportPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Import\ImportedMember::MEMBER_IMPORT_PERMISSION);
    /** @var \App\Models\Filter\MemberFilter $memberFilter */
    $memberFilter = $this->getMemberFilter();
    /** @var \App\Models\Member $member */
@endphp

<x-slot name="headline">
    {{ __('Member Overview') }}
</x-slot>
@if($hasEditPermission)
    <x-slot name="headerBtn">
        <a href="{{route('member.create')}}" class="btn btn-success max-sm:text-lg gap-2"
           title="Create new member">
            <i class="fa-solid fa-plus"></i>
            <span class="max-sm:hidden">{{__("Add new member")}}</span>
        </a>
    </x-slot>
@endif

<div class="flex flex-col gap-5">
    <x-livewire.filter.member-filter/>

    @if($this->members->exists())

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
            <x-livewire.loading/>

            <x-always-responsive-table class="table-auto mx-auto text-center">
                <thead class="font-bold">
                <tr class="max-md:hidden">
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
                            $rowBg = "bg-lime-200 text-red-700";
                        } elseif($member->entrance_date > now() ||
                         ($member->leaving_date && $member->leaving_date < now())) {
                            $rowBg = "bg-gray-300 text-gray-600";
                        } elseif($member->paused) {
                            $rowBg = "bg-gray-300";
                        }
                    @endphp
                    <tr class="[&:nth-child(2n)]:bg-opacity-50 max-md:block max-md:py-2 {{$rowBg}}">
                        <td class="max-md:block md:border px-4">{{ $member->getFullName() }}</td>
                        <td class="max-md:hidden border px-4">{{ $member->birthday?->format("Y-m-d") }}</td>
                        <td class="max-md:block max-md:text-sm max-md:text-gray-500 md:border px-4">{{ $member->email }}</td>
                        <td class="max-md:block max-md:text-sm max-md:text-gray-500 md:border px-4">{{ $member->phone }}</td>
                        <td class="max-md:hidden border px-4">
                            <ul class="list-disc text-left pl-3">
                                @foreach($member->memberGroups()->get() as $memberGroup)
                                    <li title="{{$memberGroup->title}}">{{$memberGroup->title}}</li>
                                @endforeach
                            </ul>
                        </td>
                        @if($hasEditPermission)
                            <td class="max-md:block md:border">
                                <div class="flex gap-2 justify-center">
                                    @if($member->paused)
                                        <button type="button" title="{{__("Unpause this member")}}"
                                                class="text-red-500"
                                                wire:click="togglePausedState({{$member->id}})">
                                            <i class="fa-solid fa-toggle-off text-base"></i>
                                        </button>
                                    @else
                                        <button type="button" title="{{__("Pause this member")}}"
                                                class="text-green-600"
                                                wire:click="togglePausedState({{$member->id}})">
                                            <i class="fa-solid fa-toggle-on text-base"></i>
                                        </button>
                                    @endif
                                    <a href="{{route('member.edit', $member->id)}}" title="Edit member"
                                       class="btn btn-primary">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                </div>
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


        <div class="bg-white shadow-sm sm:rounded-lg p-5">
            <div class="flex flex-wrap gap-2 justify-start w-full sm:w-auto">

                <div x-data="{
                        open:false,
                    }" class="relative inline-block text-left" @click.outside="open = false">
                    <div>
                        <button type="button" x-ref="exportDropdownButton"
                                class="btn btn-secondary"
                                @click.stop="open = !open">
                            <i class="fa-solid fa-file-export"></i> Export
                            <i class="fa-solid fa-chevron-down text-gray-400 transition"
                               :class="open ? 'rotate-180' : ''"></i>
                        </button>
                    </div>

                    <div x-cloak x-show="open" x-anchor="$refs.exportDropdownButton"
                         class="z-10 mt-2 w-48 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                        <div class="py-1">
                            <div class="px-4 py-1">
                                <a class="btn w-full"
                                   href="{{route('member.list.csv', $memberFilter->toParameterArray())}}"
                                   @click="open=false"
                                   title="Download birthday list as CSV file">{{ __('CSV List') }}</a>
                            </div>
                            <div class="px-4 py-1">
                                <a class="btn w-full"
                                   href="{{route('member.list.excel', $memberFilter->toParameterArray())}}"
                                   @click="open=false"
                                   title="Download birthday list as Excel file">{{ __('Excel File') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="btn bg-cyan-700 hover:bg-cyan-500 focus:bg-cyan-500 text-white"
                   href="{{route('member.birthdayList')}}"
                   title="Show list of member birthdays">{{ __('Birthday list') }}</a>
                @if($hasImportPermission)
                    <a href="{{route('member.import')}}" class="btn btn-info ml-auto"
                       title="Import member list">
                        {{__("Import members")}}
                    </a>
                @endif
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
