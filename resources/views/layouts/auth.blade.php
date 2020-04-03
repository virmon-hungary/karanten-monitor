<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
  <div id="app">
    <div class="auth">
      <figure class="logo logo--auth mb-0">
        <img src="{{ asset('/img/logo.svg') }}" alt="Logo" class="logo__img">
      </figure>
      <h1 class="h2 text-primary text-center mb-4"><q>A biztonságos orvosi kapcsolattartás eszköze</q></h1>
      @yield('content')
    </div>
  </div>
</body>
</html>
