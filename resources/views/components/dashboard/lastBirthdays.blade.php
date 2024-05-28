@php
    /** @var \App\Models\Member $member */
    $hasShowPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\Member::MEMBER_SHOW_PERMISSION) ?? false;

@endphp
@if($hasShowPermission)
    <?php
    $today = now()->isoFormat('MM-DD');
    $limit = now()->subDays(14)->isoFormat('MM-DD');
    $memberList = \App\Models\Member::getAllFiltered()->whereNotNull('birthday')->get()
        ->filter(function ($member) use ($today, $limit) {
            $monthDay = $member->birthday->isoFormat('MM-DD');
            return $monthDay >= $limit && $monthDay <= $today;
        })
        ->sort(function ($memberA, $memberB) {
            return strcmp($memberA->birthday->isoFormat('MM-DD'), $memberB->birthday->isoFormat('MM-DD'));
        });
    ?>
    @if($memberList->isNotEmpty())
        <div class="bg-white shadow-sm sm:rounded-lg p-2 text-center mb-3">
            <header class="font-bold mb-3">{{__('Last member birthdays')}}</header>
            <ul class="flex flex-wrap justify-center gap-3">
                @foreach($memberList as $member)
                    <li class="bg-gray-300 px-2 rounded">{{$member->getFullName()}}
                        ({{$member->birthday->isoFormat('D. MMM')}})
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
@endif
