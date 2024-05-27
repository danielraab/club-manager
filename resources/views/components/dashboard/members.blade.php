@php
    /** @var \App\Models\Member $member */
    $hasShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Member::MEMBER_SHOW_PERMISSION) ?? false;
@endphp
@if($hasShowPermission)
    <div class="flex flex-col mb-3">
            @php($membersWithoutBirthday = \App\Models\Member::getAllFiltered()->whereNull('birthday'))
        <div class="bg-white shadow-sm sm:rounded-lg p-4 text-center">
            <header class="font-bold mb-3">{{__('Member without birthdays')}}</header>
            <ul class="grid text-sm gap-2">
                @foreach($membersWithoutBirthday->get() as $member)
                    <li class="p-1 bg-red-600 text-white rounded">{{$member->getFullName()}}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
