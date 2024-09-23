@props(['type' => '', 'label' => ''])
<!-- Accordion Wrapper -->
<div x-data="{show:false}" {{$attributes->class("transition hover:bg-indigo-50 border-b border-b-black")}}
     :class="show ? 'bg-indigo-50':''"
     @open-all-accordions.document="($event.detail=='{{$type}}') && (show=true)"
     @close-all-accordions.document="($event.detail=='{{$type}}') && (show=false)"
>
    <!-- header -->
    <div x-on:click="show= !show"
        class="cursor-pointer transition flex space-x-5 px-5 items-center h-12">
        <i class="fas " :class="show ? 'fa-caret-up':'fa-caret-down'"></i>
        <h3>{{__($label)}}</h3>
    </div>
    <!-- Content -->
    <div x-show="show" class="px-5 pt-0 overflow-hidden" x-collapse>
        {{$slot}}
    </div>
</div>
