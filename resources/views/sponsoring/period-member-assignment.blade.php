<x-backend-layout>
    <x-slot name="headline">
        <div class="flex items-center gap-2">
            <a href="{{route("sponsoring.period.backer.overview", $period->id)}}">
                <i class="fa-solid fa-arrow-left-long"></i>
            </a>
            {{ __("Assign members to backers") }}
        </div>
    </x-slot>

    <div x-init="$store.notificationMessages
            .addNotificationMessages(
            JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))"
         x-data="{showOnlyMemberWithAssignment:false}">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3">
            <livewire:sponsoring.quick-backer-add :period="$period"/>
        </div>

        <div class="flex flex-wrap justify-center items-center gap-2 mb-3">
            <x-input-checkbox id="memberWithAssignmentOnlyChkbx" x-model="showOnlyMemberWithAssignment">
                {{__('only member with assignment')}}
            </x-input-checkbox>
            <div>
                <button class="btn btn-primary" x-on:click="$dispatch('open-all-accordions','period-member')">{{__("open all")}}</button>
                <button class="btn btn-secondary" x-on:click="$dispatch('close-all-accordions','period-member')">{{__("close all")}}</button>
            </div>
        </div>

        <div class="flex flex-col">
            <div class="bg-white shadow-sm sm:rounded-lg lg:p-4 gap-4">
                @forelse(\App\Models\Member::getAllFiltered()->get() as $member)
                    @php
                        /** @var \App\Models\Member $member */
                        /** @var \App\Models\Sponsoring\Contract $contract */
                    @endphp
                    @if($previousPeriod)
                        <livewire:sponsoring.member-backer-assignment wire:key="{{$member->id}}"
                                                                      :member="$member" :period="$period"
                                                                      :previousPeriod="$previousPeriod"/>
                    @else
                        <livewire:sponsoring.member-backer-assignment  wire:key="{{$member->id}}"
                                                                       :member="$member" :period="$period"/>
                    @endif
                @empty
                    <div class="text-center text-gray-700">-- {{__('no members')}} --</div>
                @endforelse
            </div>
        </div>
    </div>
</x-backend-layout>
