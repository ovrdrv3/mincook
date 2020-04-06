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
                            
                            <div class="dropdown-menu" style="background-color:#49405C;" aria-labelledby="dropdownMenuButton">
                                  <a class="dropdown-item navbar" style="color: #f4efd3;" href="/home"> Dashboard </a>
                                  <a class="dropdown-item navbar" style="color: #f4efd3;" href="{{ route('logout') }}"
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

      @if (session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
      @endif

      @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
      @endif

      @yield('content')


    <footer class="pt-4 my-m-5 pt-md-5 light-purple">
        <div class="container">
          <div class="row">
            <div class="col-12 col-md">
        <h2 class="primary-font">minimum <br> cook </h2>
            </div>
            <div class="col-6 col-md">
              <h5>Features</h5>
              <ul class="list-unstyled text-small">
                <li><a class="" href="/ingredients">Find recipes by ingredient</a></li>
              </ul>
            </div>
            {{-- <div class="col-6 col-md">
              <h5>Resources</h5>
              <ul class="list-unstyled text-small">
                <li><a class="" href="#">Resource</a></li>
                <li><a class="" href="#">Resource name</a></li>
                <li><a class="" href="#">Another resource</a></li>
                <li><a class="" href="#">Final resource</a></li>
              </ul>
            </div> --}}
            <div class="col-6 col-md">
              <h5>About</h5>
              <ul class="list-unstyled text-small">
                <li><a class="" href="#">Team</a></li>
                <li><a class="" href="#">Locations</a></li>
                <li><a class="" href="#">Privacy</a></li>
                <li><a class="" href="#">Terms</a></li>
              </ul>
            </div>
      </div>
      <div class="row">
        <div class="col-12 col-md">
          <small class="d-block mb-3 ">Developed by Donaven Snowden © 2020</small>
        </div>
      </div>
      </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    </body>

</html>
