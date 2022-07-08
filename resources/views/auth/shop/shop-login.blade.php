<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{$tarh_name}}</title>
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">

</head>
<body>
<div id="app">
    <shop-login-component></shop-login-component>
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
