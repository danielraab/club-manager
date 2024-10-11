<x-section-card>
    <header class="mb-3">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Application appearance') }}
        </h2>
    </header>

    <x-livewire.loading/>
    <div
        class="rounded-md bg-white p-4 text-[0.8125rem] leading-6 text-slate-900 shadow-xl shadow-black/5 ring-1 ring-slate-700/10">
        <div class="flex items-center justify-between border-slate-400/20 py-3">
            <div>
                <span>{{__("Name")}}</span>
                <div class="text-gray-700 flex items-center gap-2">{{__("Default")}}: {{config('app.name')}}
                </div>
            </div>
            <div class="flex flex-col justify-end gap-2 items-center">
                <x-input type="text" wire:model.blur="appName"/>
            </div>
        </div>
        <div class="flex items-center justify-between border-t border-slate-400/20 py-3">
            <div>
                <span>{{__("Logo")}}</span>
                <div class="text-gray-700 flex items-center gap-2">{{__("Default")}}:
                    <img src="{{ \Illuminate\Support\Facades\Vite::asset("resources/images/logo.svg")}}"
                         alt="Logo" class="h-10"/>
                </div>
            </div>

            @php
                /** @var $uploadedFile \App\Models\UploadedFile|null */
                $uploadedFile = null;
                /** @var $logoFileId int|null */
                if($logoFileId) {
                    $uploadedFile = \App\Models\UploadedFile::query()->find($logoFileId);
                }
            @endphp
            @if($uploadedFile)
                <div class="flex items-center gap-2 mx-3">
                    <i class="fa-solid fa-file"></i>
                    <a href="{{$uploadedFile->getUrl()}}" target="_blank"
                       class="underline">{{$uploadedFile->name}}</a>
                    <button type="button" class="btn btn-danger"
                            wire:click="deleteFile()"
                            wire:confirm="{{__('Are you sure you want to delete the file?')}}">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            @else
                <x-livewire.input-file-area id="logoFile" name="logoFile" type="file" class="mt-1 block w-full"
                                            wire:model="logoFile"
                                            subTitle="PNG, JPG, GIF, SVG up to 1MB"
                                            autofocus autocomplete="logoFile">
                    @if($logoFile)
                        <div class="text-center">
                            <div class="mt-2">{{__("Selected file:")}}</div>

                            <p class="list-disc text-gray-600 text-sm break-all">
                                {{$logoFile->getClientOriginalName()}}
                            </p>
                        </div>
                        <button type="button" class="btn btn-primary" wire:click="uploadFile">Upload file</button>
                    @endif
                </x-livewire.input-file-area>
            @endif

        </div>
        <div class="my-3">
            <x-input.textarea
                id="guestLayoutText"
                :label="__('Guest Layout Text')"
                class="w-full min-h-[100px]"
                wire:model="guestLayoutText"
                errorBag="guestLayoutText"
            />
        </div>
        <div class="flex items-center justify-between border-t border-slate-400/20 py-3"
             x-init
             x-on:switched="$wire.set('isDevPageAvailable', $event.detail.enabled)">
            <span>{{__("Is dev mode available ?")}}
                @if($isDevPageAvailable)
                    <a class="underline" href="{{route("development")}}">Link</a>
                    <span class="text-xs">({{\App\Http\Middleware\Development::isAvailableInSec()}} sec)</span>
                @endif
            </span>
            <x-input-switch :enabled="$isDevPageAvailable"/>
        </div>
    </div>
</x-section-card>
