<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <title>Laravel</title>
    </head>
    <body>

        <div id="app">
            <title-header />
        </div>

        <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    </body>
</html>
