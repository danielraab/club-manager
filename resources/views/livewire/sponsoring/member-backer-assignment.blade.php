<?php
/** @var \App\Models\Sponsoring\Period $period */
/** @var \App\Models\Member $member */
/** @var \App\Models\Sponsoring\Contract $contract */

$hasUserMemberEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(\App\Models\UserPermission::USER_MANAGEMENT_EDIT_PERMISSION);
?>
<x-accordion class="min-w-60 text-sm text-gray-700" type="period-member"
             x-show="{{$currentContracts->count()>0 ? 'true' : 'false'}} || !showOnlyMemberWithAssignment">
    <x-slot name="labelSlot">
        <div class="flex justify-between items-center w-full">
            <div>
                {{$member->getFullName()}}
                @if($member->email)
                    ({{ $member->email }})
                @else
                    <span class="text-red-800 font-bold">({{ __('mail missing') }})</span>
                @endif
            </div>
            @if($hasUserMemberEditPermission)
                <a href="{{route('member.edit', $member->id)}}" title="Edit member" x-on:click.stop=""
                   class="btn btn-primary">
                    <i class="fa-regular fa-pen-to-square"></i>
                </a>
            @endif
        </div>
    </x-slot>
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
                <ul class="list-disc px-4 py-2">
                    @forelse($currentContracts as $contract)
                        <li>
                            <a href="{{route('sponsoring.contract.edit', $contract->id)}}" title="Edit contract" class="underline">
                                {{$contract->backer->name}}
                            </a>
                            @if($contract->package)
                                <span class="text-xs">- {{$contract->package->title}} ({{\App\Facade\Currency::formatPrice($contract->package->price)}})</span>
                            @endif
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
                        <div class="p-3 flex flex-col gap-2">
                            @forelse($openAndCurrentBackers as $backer)
                                <x-input-checkbox :id="$member->id.'-'.$backer->id"
                                                  x-on:change="changed=true && $wire.updateBacker({{$backer->id}}, $event.target.checked)"
                                                  :checked="in_array($backer->id, $currentContracts->pluck('backer_id')->toArray())">
                                    {{$backer->name}}
                                </x-input-checkbox>
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
