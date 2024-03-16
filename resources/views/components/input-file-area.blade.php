<div
    x-data="{dragover:false, uploading: false, progress: 0, dropHandler(e){
        $refs.fileInput.files = e.dataTransfer.files;
        $refs.fileInput.dispatchEvent(new Event('change'));
    }}"
    x-on:drop.prevent="dropHandler"
    x-on:dragover.prevent=""
    class="mt-2 flex flex-col gap-3 items-center justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-3 min-h-[150px] hover:bg-gray-100">
    <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd"
              d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z"
              clip-rule="evenodd"/>
    </svg>
    <div class="mt-2 text-sm leading-6 text-gray-600 text-center">
        <label for="{{$attributes->get("id")}}"
               class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
            <span>Upload a file</span>
            <input
                x-ref="fileInput"
                x-on:livewire-upload-start="uploading = true"
                x-on:livewire-upload-finish="uploading = false"
                x-on:livewire-upload-cancel="uploading = false"
                x-on:livewire-upload-error="uploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
                {{$attributes->class("sr-only")}}
                type="file">
        </label>
        <span>or drag and drop</span>
        @if($subTitle)
            <p class="text-xs text-gray-600">{{__($subTitle)}}</p>
        @endif
    </div>
    <div class="flex flex-col justify-center items-center gap-2 w-full" x-show="uploading" x-cloak>
        <progress class="rounded-full w-full h-2" max="100" x-bind:value="progress"></progress>
        <button type="button" class="btn btn-danger text-sm" wire:click="$cancelUpload('{{$attributes->get('wire:model')}}')">Cancel Upload</button>
    </div>
    @if($slot)
        {{$slot}}
    @endif
</div>
