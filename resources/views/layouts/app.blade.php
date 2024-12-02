<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Roboto:wght@400&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/ico">

    <style>
        .hero {
            background-image: url("{{ asset('img/herobg2.jpg') }}");
        }
    </style>
</head>
<body>
    <div id="app" style="display: flex; flex-direction: column; min-height: 100vh;">
        <header>
            <h1>@yield('header_title', 'Default Title')</h1>
            @auth
                <span class="user-name">Logged in as: {{ Auth::user()->name }}</span>
            @endauth
        </header>
        <main style="flex: 1;">
            @yield('content')
        </main>
        <footer>
            <p>© 2024 PromptProfile</p>
            <p>Favicon made by Fabio Nucatolo from <a href="https://thenounproject.com/browse/icons/term/nettle/" target="_blank" title="nettle Icons">Noun Project</a> (CC BY 3.0)</p>
        </footer>
    </div>
</body>
</html>
