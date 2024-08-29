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
            JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3 ">
            <livewire:sponsoring.quick-backer-add/>
        </div>

        <div class="flex flex-col">
            <div class="bg-white shadow-sm sm:rounded-lg lg:p-4 gap-4">
                @forelse(\App\Models\Member::getAllFiltered()->get() as $member)
                    @php
                        /** @var \App\Models\Member $member */
                        /** @var \App\Models\Sponsoring\Contract $contract */
                    @endphp
                    @if($previousPeriod)
                        <livewire:sponsoring.member-backer-assignment :member="$member" :period="$period"
                                                                      :previousPeriod="$previousPeriod"/>
                    @else
                        <livewire:sponsoring.member-backer-assignment :member="$member" :period="$period"/>
                    @endif
                @empty
                    <div class="text-center text-gray-700">-- {{__('no members')}} --</div>
                @endforelse
            </div>
        </div>
    </div>
</x-backend-layout>
