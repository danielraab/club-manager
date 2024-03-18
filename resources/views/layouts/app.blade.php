<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Club management') }}</title>


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100 xl:ml-[310px]">
    <header class="bg-white border-b border-gray-300 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center py-3 gap-3">
            @include('layouts.navigation')
            <!-- Page Heading -->
            @if (isset($header))
                <h1>
                    {{ $header }}
                </h1>
            @endif
        </div>
    </header>

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
    <footer class="text-center text-gray-500 pb-3">
        <i class="fa-regular fa-copyright"></i>
        <span>draab.at - <span
                title="{{config("app.deployDateTime")?->formatDateTimeWithSec()}}">{{config("app.version")}}</span></span>
    </footer>
</div>
<script>
    window.cookieStorage = {
        getItem(key) {
            let cookies = document.cookie.split(";");
            for (let i = 0; i < cookies.length; i++) {
                let cookie = cookies[i].split("=");
                if (key == cookie[0].trim()) {
                    return decodeURIComponent(cookie[1]);
                }
            }
            return null;
        },
        setItem(key, value) {
            document.cookie = key + ' = ' + encodeURIComponent(value)
        }
    }
</script>
@livewireScripts
</body>
</html>
