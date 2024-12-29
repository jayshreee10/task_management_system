<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Include your CSS or JS assets -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <div id="app">
        @include('layouts.header')
        <main>
            @yield('content')
        </main>
        @include('layouts.footer')
    </div>
</body>
</html>
