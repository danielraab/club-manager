<x-backend-layout>
    <x-slot name="headline">
        <span>{{ __('Member Group Overview') }}</span>
    </x-slot>
    <x-slot name="headerBtn">
        <a href="{{route('member.group.create')}}" class="btn btn-create text-lg" title="Create new member group">
            <i class="fa-solid fa-plus"></i>
        </a>
    </x-slot>

    <div class="flex flex-col gap-3 bg-white shadow-sm sm:rounded-lg p-6 text-gray-900">
        <div class="mx-auto">
            @foreach(\App\Models\MemberGroup::getTopLevelQuery()->get() as $memberGroup)
                <x-members.member-group-list-item :memberGroup="$memberGroup" class="my-2"/>
            @endforeach
        </div>
    </div>

</x-backend-layout>
