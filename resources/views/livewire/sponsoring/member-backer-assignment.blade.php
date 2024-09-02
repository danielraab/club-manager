<?php
/** @var \App\Models\Sponsoring\Period $period */
/** @var \App\Models\Member $member */
/** @var \App\Models\Sponsoring\Contract $contract */
?>
<x-accordion label="{{$member->getFullName()}}" class="min-w-60 text-sm text-gray-700">
    <x-livewire.loading/>
    <div x-init="$store.notificationMessages
                 .addNotificationMessages(
                 JSON.parse('{{\App\Facade\NotificationMessage::popNotificationMessagesJson()}}'))"></div>
    <div class="grid lg:grid-cols-2 gap-3 pb-3">
        <div class="rounded bg-gray-400 p-2">
            <h3 class="text-lg font-bold">{{__("last backers")}}</h3>
            <ul class="list-disc px-4 py-2">
                @forelse($previousContracts as $contract)
                    <li>{{$contract->backer->name}} ({{$contract->period->title}})</li>
                @empty
                    <div>{{__('no last contracts')}}</div>
                @endforelse
            </ul>
        </div>
        <div>
            <h3 class="text-lg font-bold">{{__("this period")}} - {{$period->title}}</h3>
            <div class="space-y-2 px-4 py-2">
                <ul>
                    @php
                        $currentContracts = $period->contracts()->where('member_id', $member->id)->get();
                    @endphp
                    @forelse($currentContracts as $contract)
                        <li>
                            {{$contract->backer->name}}
                        </li>
                    @empty
                        <div>{{__('no backer is taken')}}</div>
                    @endforelse
                </ul>
                <div x-init
                     x-data="{
                        changed:false,
                        closeModalHandler() {
                            if(this.changed) {
                                this.changed = false;
                                $wire.dispatch('member-contract-has-changed');
                            }
                        }
                     }"
                     x-on:close-modal.window="closeModalHandler()"
                >
                    <x-modal id="member-contract-assignment-{{$member->id}}"
                             title="{{$member->getFullName()}} - {{$period->title}}"
                             focusable showX>
                        <div class="p-3">
                            @forelse($openAndCurrentBackers as $backer)
                                <div>
                                    <x-input-checkbox :id="$member->id-$backer->id"
                                                      x-on:change="changed=true && $wire.updateBacker({{$backer->id}}, $event.target.checked)"
                                                      :checked="in_array($backer->id, $currentBackers)">
                                        {{$backer->name}}
                                    </x-input-checkbox>
                                </div>
                            @empty
                                <div>{{__('all backers are taken')}}</div>
                            @endforelse
                        </div>
                    </x-modal>
                </div>
            </div>
            <div class="flex justify-between">
                <button type="button" class="btn btn-primary"
                    @if(!$member->email || $currentContracts->isEmpty())
                        disabled
                    @else
                        wire:confirm="Are you sure to send a mail to {{$member->getFullName()}} ({{$member->email}}) ?"
                        wire:click="sendSummaryMailToMember"
                    @endif
                >
                    {{__("Send mail")}}
                </button>
                <button type="button" class="btn btn-success"
                        x-on:click.prevent="$dispatch('open-modal', 'member-contract-assignment-{{$member->id}}')">
                    {{__("Assign new")}}
                </button>
            </div>
        </div>
    </div>
</x-accordion>
