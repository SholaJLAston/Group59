<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Apex Hardware Supply & Tools</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <!-- Global styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Page-specific CSS -->
    @yield('extra-css')
</head>
<body>

    <!-- Navigation -->
  @include('layouts.nav')

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
  @include('layouts.footer')

    <!-- Global JS -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Page-specific JS -->
    @yield('extra-js')
</body>
</html>