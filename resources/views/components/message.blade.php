@php
    $background = match (session()->pull("messageType", "info")) {
        "success" => "bg-success",
        default => "bg-info",
    }
@endphp

@if(session()->has("message"))
    @php($messages = session()->pull("message"))
    @php($messages = is_array($messages) ? $messages : [$messages])
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-1">
        @foreach($messages as $message)
        <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-2" role="alert">
            <i class="fa-solid fa-info mr-3"></i>
            <p>{{$message}}</p>
        </div>
        @endforeach
    </div>
@endif
