<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Member Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("If your mail address corresponds to a member mail the member information are shown here.") }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        @php
            /** @var \App\Models\User $user */
            $user = auth()->user();
            /** @var \App\Models\Member $member */
            $member = $user?->getMember();
        @endphp
        @if($member)
            <div>
                @if($member->paused)
                    <span class="w-fit px-2 py-1 rounded-full text-sm bg-orange-700 text-white">{{__('paused')}}</span>
                @endif
                @if($member->leaving_date)
                    <span class="w-fit px-2 py-1 rounded-full text-sm bg-indigo-800 text-white">{{__('retired')}}</span>
                @endif
            </div>
            <div class="grid grid-cols-2">
                <div class="flex flex-col gap-2">
                    <div>
                        <div class="font-bold">{{__('Name')}}:</div>
                        <div class="ml-5">{{$member->getFullName()}}</div>
                    </div>
                    <div>
                        <div class="font-bold">{{__('Birthday')}}:</div>
                        @if($member->birthday)
                            <div class="ml-5">{{$member->birthday->formatDateOnly()}}</div>
                        @else
                            <div class="ml-5 text-red-800">{{__('missing')}}</div>
                        @endif
                    </div>
                    <div>
                        <div class="font-bold">{{__('Phone')}}:</div>
                        @if($member->phone)
                            <div class="ml-5">{{$member->phone}}</div>
                        @else
                            <div class="ml-5 text-red-800">{{__('missing')}}</div>
                        @endif
                    </div>
                    <div>
                        <div class="font-bold">{{__('Address')}}:</div>
                        @if($member->street)
                            <div class="ml-5">{{$member->street}}, {{$member->zip}} {{$member->city}}</div>
                        @else
                            <div class="ml-5 text-red-800">{{__('missing')}}</div>
                        @endif
                    </div>
                </div>
                <div>
                    <div class="font-bold">{{__('Membergroups')}}:</div>
                    <div class="ml-5">
                        @if(($memberGroups = $member->memberGroups()->get())->isNotEmpty())
                            <ul class="list-disc ml-4">
                                @foreach($memberGroups as $memberGroup)
                                    <li>{{$memberGroup->title}}</li>
                                @endforeach
                            </ul>
                        @else
                            {{__('No assigned members.')}}
                        @endif
                    </div>
                </div>
            </div>
            <div
                class="mt-3 text-gray-500 text-center">{{__('If this is not your information please contact your admin.')}}</div>
        @else
            <span
                class="text-gray-700">{{__('No member with your Mail address found. Please contact your admin.')}}</span>
        @endif
    </div>
</section>
