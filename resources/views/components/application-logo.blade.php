{{-- add setting set own application logo --}}
@php
    /** @var \App\Models\UploadedFile $logoFile */
    $logoFile = null;
    $logoId = \App\Models\Configuration::getInt(\App\Models\ConfigurationKey::APPEARANCE_APP_LOGO_ID);
    if($logoId) {
        $logoFile = \App\Models\UploadedFile::query()->find($logoId);
    }
@endphp
<img src="{{ $logoFile?->getUrl() ?? \Illuminate\Support\Facades\Vite::asset("resources/images/logo.svg")}}"
     alt="Logo" {{ $attributes }}/>
