<?php
/** @var \App\Models\Sponsoring\Period $period */
/** @var \App\Models\Member $member */
/** @var \App\Models\Sponsoring\Contract $contract */
?>
<x-accordion title="{{$member->getFullName()}}" class="min-w-60 text-sm text-gray-700">
    <div class="grid lg:grid-cols-2 gap-3">
        <div class="rounded bg-gray-400 p-2">
            <h3 class="text-lg font-bold">{{__("last backers")}}</h3>
            <ul class="list-disc mx-4">
                @forelse($previousContracts as $contract)
                    <li>{{$contract->backer->name}} ({{$contract->period->title}})</li>
                @empty
                    <div>{{__('no last contracts')}}</div>
                @endforelse
            </ul>
        </div>
        <div>
            <h3 class="text-lg font-bold">{{__("this period")}} - {{$period->title}}</h3>
            <div class="space-y-2">
                <ul>
                    @forelse($period->contracts()->where('member_id', $member->id)->get() as $contract)
                        <li>
                            {{$contract->backer->name}}
                        </li>
                    @empty
                        <div>{{__('no backer is taken')}}</div>
                    @endforelse
                </ul>
                <div x-init>
                    <button type="button" class="btn btn-success"
                            x-on:click.prevent="$dispatch('open-modal', 'member-contract-assignment-{{$member->id}}')">
                        Assign new
                    </button>

                    <x-modal name="member-contract-assignment-{{$member->id}}"
                             :show="$errors->userDeletion->isNotEmpty()" focusable>
                        <div>
                            @forelse($openAndCurrentBackers as $backer)
                                <div>
                                    <x-input-checkbox :id="$backer->id"
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
        </div>
    </div>
</x-accordion>
