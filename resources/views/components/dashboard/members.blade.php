@php
    /** @var \App\Models\Member $member */
    $hasEditPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Member::MEMBER_EDIT_PERMISSION) ?? false;
@endphp
@if($hasEditPermission)
    <div class="flex-1 flex flex-col mb-3 bg-white shadow-sm sm:rounded-lg p-4 text-center">
        <div class="flex justify-center items-center gap-2 text-xl">
            <i class="fa-solid fa-user-pen"></i>
            <span>{{__('member management')}}</span>
        </div>
        @php($isDataConsistent = false)
        @php($membersWithoutBirthday = \App\Models\Member::getAllFiltered()->whereNull('birthday')->get())
        @if($membersWithoutBirthday->isNotEmpty())
            <hr class="my-3">
            <header class="font-bold mb-3">{{__('without birthdays')}}</header>
            <ul class="grid text-sm gap-2 text-white">
                @foreach($membersWithoutBirthday as $member)
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
        @endif
        @if($missingEmailCnt = \App\Models\Member::getAllFiltered()->whereNull('email')->count())
        @php($isDataConsistent = false)
        <hr class="my-3">
        <div class="text-red-800">
            <i class="fa-solid fa-at"></i>
            <span>{{__(':cnt email(s) missing', ['cnt' => $missingEmailCnt])}}</span>
        </div>
        @endif
        @if($isDataConsistent)
            <hr class="my-3">
            <span class="text-green-800"><i class="fa-solid fa-user-check"></i>{{__('member data is consistent')}}</span>
        @endif
    </div>
@endif
