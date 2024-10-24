@props([
    'type' => '',
    'label' => '',
    'labelSlot' => '',
])
<!-- Accordion Wrapper -->
<div x-data="{show:false}" {{$attributes->class("transition")}}
     @open-all-accordions.document="($event.detail=='{{$type}}') && (show=true)"
     @close-all-accordions.document="($event.detail=='{{$type}}') && (show=false)"
>
    <!-- header -->
    <div x-on:click="show= !show"
        class="cursor-pointer transition flex justify-between px-5 items-center h-12">
        @if($labelSlot)
            {{$labelSlot}}
        @else
        <h3>{{__($label)}}</h3>
        @endif
        <i class="fas " :class="show ? 'fa-minus':'fa-plus'"></i>
    </div>
    <!-- Content -->
    <div x-show="show" class="px-5 pt-0 overflow-hidden" x-collapse>
        {{$slot}}
    </div>
</div>
