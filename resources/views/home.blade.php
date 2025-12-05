<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Index</title>
        <link rel="stylesheet" href="{{ asset('css/Main.css') }}">
    </head>
    <body>
        <x-header />
        
        <h1>Index Page</h1>
    </body>
</html>