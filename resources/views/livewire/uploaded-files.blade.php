<div>
    <x-slot name="headline">
        {{ __('Files') }}
    </x-slot>

    <x-livewire.loading/>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="shadow-xl shadow-black/5 sm:rounded-md bg-white p-3">
            <h3 class="font-bold">Uploaded files:</h3>
            <ul class="list-disc my-3 mx-5">
                @forelse($files as $file)
                    <x-uploaded-files-item :file="$file"/>
                @empty
                    <span>{{__("no files")}}</span>
                @endforelse
            </ul>
        </div>
        <div class="shadow-xl shadow-black/5 sm:rounded-md bg-white p-3">
            <h3 class="font-bold">Additional not known files:</h3>
            <ul class="list-disc my-3 mx-5">
                @foreach($additionalFilesInFolder as $path)
                    <li class="ml-3">
                        @if(\Illuminate\Support\Facades\Storage::exists($path))
                            <span wire:click="forceDownload('{{$path}}')"
                                  class="underline cursor-pointer">{{$path}}</span>
                        @else
                            {{$path}}
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
