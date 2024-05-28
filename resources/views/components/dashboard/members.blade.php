@php
    /** @var \App\Models\Member $member */
    $hasShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Member::MEMBER_SHOW_PERMISSION) ?? false;
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Member::MEMBER_EDIT_PERMISSION) ?? false;
@endphp
@if($hasShowPermission || $hasEditPermission)
    <div class="flex-1 flex flex-col mb-3">
            @php($membersWithoutBirthday = \App\Models\Member::getAllFiltered()->whereNull('birthday'))
        <div class="bg-white shadow-sm sm:rounded-lg p-4 text-center">
            <header class="font-bold mb-3">{{__('Member without birthdays')}}</header>
            <ul class="grid text-sm gap-2 text-white">
                @foreach($membersWithoutBirthday->get() as $member)
                    <li class="flex p-1 bg-red-600 rounded gap-4 justify-center">
                        <span>{{$member->getFullName()}}</span>
                        @if($hasEditPermission)
                            <a href="{{route('member.edit', $member->id)}}" title="Edit member">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
