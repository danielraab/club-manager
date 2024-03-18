@if(trim($slot))
    <div x-data="{open:false}">
        <!-- Logo -->
        <div class="flex flex-row justify-between items-center">
            {{$mainLink}}
            <button type="button" @click="open = !open" class="px-3">
                <i class="fa-solid" :class="{'fa-plus':!open, 'fa-minus':open}"></i>
            </button>
        </div>
        <div x-show="open" x-collapse class="ml-6">
            {{$slot}}
            <hr>
        </div>
    </div>
@else
    {{$mainLink}}
@endif
