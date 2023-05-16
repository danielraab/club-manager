@php
    $background = match (session()->pull("messageType", "info")) {
        "success" => "bg-success",
        default => "bg-info",
    }
@endphp

@if(session()->has("message"))
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
            <i class="fa-solid fa-info mr-3"></i>
            <p>{{session()->pull("message")}}</p>
        </div>
    </div>
@endif
