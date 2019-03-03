<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'minimum cook') }}</title>

        <!-- CSS and Fonts -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

    </head>
    <body class="background-gradient">

      <nav id="top-nav" class="navbar navbar-expand-md navbar-light navbar-laravel">
          {{-- <div class="container"> --}}

              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <!-- Left Side Of Navbar -->
                  <ul class="navbar-nav mr-auto">
                    <li><a class="" href="/">home</a></li>
                    <li><a class="" href="/recipes">recipes</a></li>
                    <li><a class="" href="/ingredients">ingredients</a></li>
                    <li><a class="" href="/create">new recipe</a></li>
                    {{-- <li><a class="" href="/tips">tips</a></li> --}}
                  </ul>

                  <!-- Right Side Of Navbar -->
                  <ul class="navbar-nav ml-auto">
                      <!-- Authentication Links -->
                      @guest
                          <li><a class="" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                          <li><a class="" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                      @else
                          <li class="nav-item dropdown">
                              <a id="navbarDropdown" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                  {{ Auth::user()->name }} <span class="caret"></span>
                              </a>

                              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                  <a class="dropdown-item" href="{{ route('logout') }}"
                                     onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                                      {{ __('Logout') }}
                                  </a>

                                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                      @csrf
                                  </form>
                              </div>
                          </li>
                      @endguest
                  </ul>
              </div>
          {{-- </div> --}}
      </nav>

      @yield('content')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    </body>

</html>
