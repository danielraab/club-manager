<x-slot name="headline">
    <div class="flex justify-between items-center">
        {{ __("Create new member group") }}
    </div>
</x-slot>

<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 p-5">
        <div class="flex items-center justify-end">
            <x-default-button class="btn-primary" wire:click="saveMemberGroup"
                              title="Create new member group">{{ __('Save') }}</x-default-button>
        </div>
    </div>


    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-4">

        <x-livewire.members.member-group-content :memberGroup="$memberGroup"/>

{{--        <div class="bg-white shadow-sm sm:rounded-lg p-4">--}}
{{--            <section>--}}
{{--                <header>--}}
{{--                    <h2 class="text-lg font-medium text-gray-900">--}}
{{--                        {{ __('Members') }}--}}
{{--                    </h2>--}}
{{--                    <p class="mt-1 text-sm text-gray-600">--}}
{{--                        {{ __("Member associated with this group:") }}--}}
{{--                    </p>--}}
{{--                </header>--}}
{{--                <div class="my-3">--}}
{{--                    <ul class="list-disc ml-4">--}}
{{--                        @forelse($memberGroup->members()->get() as $member)--}}
{{--                        <li>--}}
{{--                            <span>{{$member->lastname}} {{$member->firstname}}</span>--}}
{{--                        </li>--}}
{{--                        @empty--}}
{{--                            <span>{{__("no assigned members")}}</span>--}}
{{--                        @endforelse--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </section>--}}
{{--        </div>--}}
    </div>

</div>
