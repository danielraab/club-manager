@props(["memberGroup", "currentEditingMemberGroup" => null, "level" => 0])
@php
/** @var \App\Models\MemberGroup $memberGroup */
@endphp

@if($memberGroup->id !== $currentEditingMemberGroup?->id)
    <option
        value="{{ $memberGroup->id }}">{{str_repeat("|--- ", $level)}}{{ $memberGroup->title }}</option>
    @foreach($memberGroup->children()->get() as $child)
        <x-members.member-group-select-option :memberGroup="$child" :level="$level+1" :currentEditingMemberGroup="$currentEditingMemberGroup" />
    @endforeach
@endif
