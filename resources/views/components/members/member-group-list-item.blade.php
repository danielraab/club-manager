@props(["memberGroup"])
@php
    /** @var \App\Models\EventType $eventType */
@endphp
<div {{$attributes}}>
    <div class="border border-sky-500 px-2 py-1 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-caret-right mx-2"></i>
            <div>
                <div class="text-sm sm:text-base">
                    {{$memberGroup->title}}
                </div>
                <div class="text-xs text-gray-500">{{$memberGroup->description}}</div>
            </div>
        </div>

        <div class="mx-2 flex gap-2 items-center">
            <span class="text-gray-500" title="{{__("Member count")}}">{{$memberGroup->members()->whereNull("leaving_date")->count()}}</span>
            <x-button-link href="{{route('member.group.edit', $memberGroup->id)}}" title="Edit this member group"
                           class="bg-gray-800 text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <i class="fa-regular fa-pen-to-square"></i>
            </x-button-link>
        </div>
    </div>
    @php($children = $memberGroup->children()->get())

    @if($children->isNotEmpty())
        <div class="ml-10">
            @foreach($children as $child)
                <x-members.member-group-list-item :memberGroup="$child"/>
            @endforeach
        </div>
    @endif
</div>
