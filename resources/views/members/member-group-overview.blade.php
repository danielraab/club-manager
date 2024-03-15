
<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <span>{{ __('Member Group Overview') }}</span>
            <a href="{{route('member.group.create')}}" class="btn-create" title="Create new member group">
                {{__("Add member group")}}
            </a>
        </div>
    </x-slot>


    <div class="flex flex-col gap-3 bg-white shadow-sm sm:rounded-lg p-6 text-gray-900">
        <div class="mx-auto">
        @foreach(\App\Models\MemberGroup::getTopLevelQuery()->get() as $memberGroup)
                <x-members.member-group-list-item :memberGroup="$memberGroup" class="my-2"/>
        @endforeach
        </div>
    </div>

</x-backend-layout>
