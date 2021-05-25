<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Tembi') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="shortcut icon" href="{{ asset('img/tembi-mini.png') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="main-page">
        <a href="{{ url('/') }}"><img class="main-logo" src="{{ asset('img/tembi-grande.png')}}" /></a>
        <div class="main-buttons">
            <a class="login-main" href="{{ route('login') }}">Log In</a>
            <a class="register-main" href="{{ route('register') }}">Register</a>
        </div>
    </div>
</body>

<footer>
    <div class="main-footer">
        <a href="">Terms </a><a href=""> Privacy</a> <p>{{ date('Y') }} Copyright © TEMBI - Ekaitz Jiménez</p>
    </div>
</footer>

</html>