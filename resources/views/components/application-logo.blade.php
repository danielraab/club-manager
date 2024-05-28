{{-- add setting set own application logo --}}

<img src="{{ \App\Models\ApplicationLogo::getUrl() }}"
     alt="Logo" {{ $attributes }}/>
