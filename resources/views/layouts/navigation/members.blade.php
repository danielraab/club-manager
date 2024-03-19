@php
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Member::MEMBER_EDIT_PERMISSION);
    $hasImportPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\Import\ImportedMember::MEMBER_IMPORT_PERMISSION);
@endphp
<x-nav-dropdown>
    <x-slot name="mainLink">
        @if(Auth::user()->hasPermission(\App\Models\Member::MEMBER_SHOW_PERMISSION, \App\Models\Member::MEMBER_EDIT_PERMISSION))
            <x-responsive-nav-link :href="route('member.index')"
                                   iconClasses="fa-solid fa-users"
                                   :active="request()->routeIs('member.*')">
                {{ __('Members') }}
            </x-responsive-nav-link>
        @endif
    </x-slot>
    @if($hasEditPermission)
        <x-responsive-nav-link href="{{route('member.create')}}" title="Create new member"
                               iconClasses="fa-solid fa-user-plus"
                               :active="request()->routeIs('member.create')">
            {{__("Add new member")}}
        </x-responsive-nav-link>
        <x-responsive-nav-link href="{{route('member.group.index')}}" title="Show member group list"
                                iconClasses="fa-solid fa-user-group"
                               :active="request()->routeIs('member.group.index')">
            {{__("Member Groups")}}
        </x-responsive-nav-link>
    @endif
    @if($hasImportPermission)
        <x-responsive-nav-link href="{{route('member.import')}}"
                               title="Import member list"
                               iconClasses="fa-solid fa-file-import">
            {{__("Import members")}}
        </x-responsive-nav-link>
    @endif
    <x-responsive-nav-link href="{{route('member.birthdayList')}}"
                           iconClasses="fa-solid fa-cake-candles"
                           title="Show list of member birthdays">
        {{ __('Birthday list') }}
    </x-responsive-nav-link>
</x-nav-dropdown>
