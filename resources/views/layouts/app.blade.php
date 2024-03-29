<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tembi') }} | Discovering photography </title>

    <!-- Scripts -->
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="shortcut icon" href="{{ asset('img/tembi-mini.png') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!--Anti copy-->
    <body ondragstart="return false" onselectstart="return false" oncontextmenu="return false">

    <!--Google analytics-->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-15VV2SGHQ4"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-15VV2SGHQ4');
    </script>    
    
</head>

    <!-- Cookie Consent by https://www.CookieConsent.com -->
    <script type="text/javascript" src="//www.cookieconsent.com/releases/4.0.0/cookie-consent.js" charset="UTF-8">
    </script>
    <script type="text/javascript" charset="UTF-8">
    document.addEventListener('DOMContentLoaded', function() {
        cookieconsent.run({
            "notice_banner_type": "interstitial",
            "consent_type": "express",
            "palette": "light",
            "language": "en",
            "page_load_consent_levels": ["strictly-necessary"],
            "notice_banner_reject_button_hide": false,
            "preferences_center_close_button_hide": false,
            "website_name": "www.tembi.com.devel/",
            "website_privacy_policy_url": "www.tembi.com.devel/privacy"
        });
    });
    </script>
    <!-- End Cookie Consent by https://www.CookieConsent.com -->

    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <div class="logo">
                            <img src="{{ asset('img/tembi.png')}}">
                        </div>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            <!--como invitado-->
                            @guest
                            <!--comprobar la ruta para saber que boton mostrar-->
                            @if (Request::is('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                            @elseif (Request::is('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Log In') }}</a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Log In') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>

                            @endif


                            @else
                            <li class="nav-item home-icon">
                                <a class="nav-link top-icon" href="{{ route('home') }}">
                                    <img src="{{asset('img/home.png')}}" />
                                </a>
                            </li>
                            <li class="nav-item people-icon">
                                <a class="nav-link top-icon" href="{{ route('user.index') }}">
                                    <img src="{{asset('img/people.png')}}" />
                                </a>
                            </li>
                            <li class="nav-item heart-icon">
                                <a class="nav-link top-icon" href="{{ route('likes') }}">
                                    <img src="{{asset('img/main-heart.png')}}" />
                                </a>
                            </li>
                            <li class="nav-item add-icon">
                                <a class="nav-link top-icon" href="{{ route('image.create') }}">
                                    <img src="{{asset('img/add.png')}}" />
                                </a>
                            </li>
                            <a href="{{ route('profile', ['id' => Auth::user()->id]) }}">
                                @include('includes.avatar')
                            </a>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle name-dropdown top-icon" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item top-dropdown"
                                        href="{{ route('profile', ['id' => Auth::user()->id])}}">
                                        My Profile
                                    </a>
                                    <a class="dropdown-item top-dropdown" href="{{ route('settings') }}">
                                        Settings and privacy
                                    </a>
                                    <a class="dropdown-item cerrar-sesion" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item add-icon">
                                <a class="nav-link top-icon top-bell" href="{{ route('activity') }}">
                                    <img src="{{asset('img/bell.png')}}" />
                                </a>
                            </li>
                            <li class="nav-item add-icon">
                                <a class="nav-link top-icon top-trendy" href="{{ route('trendy') }}">
                                    <img src="{{asset('img/popular.png')}}" />
                                </a>
                            </li>
                            @if (Auth::user()->role == '1234')
                            <li class="nav-item add-icon">
                                <a class="nav-link top-icon top-admin" href="{{ route('admin') }}">
                                    <img src="{{asset('img/admin.png')}}" />
                                </a>
                            </li>
                            @endif
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </body>

</html>