<!DOCTYPE html>
<html lang="pl" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ \App\Models\Setting::get('site_description') ?? 'Laravel' }}">
    <meta name="keywords" content="{{ \App\Models\Setting::get('site_keywords') ?? 'Laravel' }}">

    <x-seo::meta />

    <title>{{ \App\Models\Setting::get('site_name') ?? config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ \App\Models\Setting::get('favicon') ?? asset('images/favicon.png') }}" />

    @vite(['resources/css/app.css'])
</head>
<body>
    <x-header-navbar />

    @if(!Auth::User())
        <x-change-theme />
    @endif

    {{ $slot }}

    @if(Auth::User())
        <x-user-panel />
    @endif

    <x-footer />

    <script>
        const currentTheme = localStorage.getItem("theme") ?? "light";
        if (currentTheme === "dark") {
            document.documentElement.setAttribute('data-theme', 'dark');
        } else if (currentTheme === "light") {
            document.documentElement.setAttribute('data-theme', 'light');
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @yield('scripts')
    @vite(['resources/js/app.js'])
    <x-head.tinymce-config/>
</body>
</html>
