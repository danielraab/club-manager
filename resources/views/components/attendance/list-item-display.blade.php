@php
    /** @var \App\Models\Attendance $attendance */
    $cssClasses = $attendance?->attended ? " bg-green-300" : '';
@endphp
<div class="flex gap-2 items-center px-2">
    <div class="h-2 w-2 rounded-full {{match($attendance?->poll_status){
                        "in" => 'bg-green-700',
                        "unsure" => 'bg-yellow-600',
                        "out" => 'bg-red-700',
                        default => ''} }}"></div>
    <span class="rounded px-2 {{$cssClasses}}">{{__($member->getFullName())}}</span>
</div>
