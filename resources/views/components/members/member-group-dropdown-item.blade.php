@props(["memberGroup", "level" => 0, "selectedMemberGroup"=>false])
@php
/** @var \App\Models\MemberGroup $memberGroup */
@endphp

<li @click="$dispatch('member-group-clicked', {{$memberGroup->id}})"
    class="cursor-pointer px-2 py-1
    @if($selectedMemberGroup == $memberGroup->id) bg-gray-700 text-white @endif">
    {{str_repeat("|--- ", $level)}}{{ $memberGroup->title }}
</li>
@if(($list = $memberGroup->children()->get())->isNotEmpty())
<ul>
    @foreach($memberGroup->children()->get() as $child)
        <x-members.member-group-dropdown-item :memberGroup="$child" :level="$level+1" :selectedMemberGroup="$selectedMemberGroup"/>
    @endforeach
</ul>
@endif
