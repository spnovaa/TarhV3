<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>

    <title>{{$tarh_name}}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- js Jalali Date -->
    <script src="{{asset('js/jdate.min.js')}}" type="text/javascript" charset="utf-8"></script>
</head>
<body>
{{-- <div id="app" >
    <navbar-component style="font-family:'Samim' !important"></navbar-component>
</div> --}}
<div id="app">
    <admin-app-container style="font-family:'Samim' !important"></admin-app-container>
</div>

</body>
</html>
