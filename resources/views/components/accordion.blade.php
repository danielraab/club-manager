<!-- Accordion Wrapper -->
<div x-data="{show:false}" class="transition hover:bg-indigo-50" :class="show ? 'bg-indigo-50':''">
    <!-- header -->
    <div x-on:click="show= !show"
        class="cursor-pointer transition flex space-x-5 px-5 items-center h-16">
        <i class="fas " :class="show ? 'fa-minus':'fa-plus'"></i>
        <h3>{{__($title)}}</h3>
    </div>
    <!-- Content -->
    <div x-show="show" class="px-5 pt-0 overflow-hidden" x-transition.duration.500ms>
        {{$slot}}
    </div>
</div>
