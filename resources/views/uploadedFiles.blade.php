<div>
    <x-slot name="headline">
        {{ __('Uploaded Files') }}
    </x-slot>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="shadow-xl shadow-black/5 sm:rounded-md bg-white p-3">
                <ul class="list-disc">
                @foreach(\App\Models\UploadedFile::withTrashed()->orderBy('storer_type', 'desc')->get() as $file)
                    <x-uploaded-files-item :file="$file"/>
                @endforeach
                </ul>
            </div>
    </div>
</div>
