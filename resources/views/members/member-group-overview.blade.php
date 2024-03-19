<x-backend-layout>
    <x-slot name="headline">
        <span>{{ __('Member Group Overview') }}</span>
    </x-slot>
    {{-- no if because you need edit permission to visit this page. --}}
    <x-slot name="headerBtn">
        <a href="{{route('member.group.create')}}"
           class="btn btn-create max-sm:text-lg gap-2"
           title="Create new member group">
            <i class="fa-solid fa-plus"></i>
            <span class="max-sm:hidden">{{__("Add member group")}}</span>
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
