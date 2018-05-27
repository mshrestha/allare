<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Unicef</title>

    <!-- Bootstrap -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css\icomoon\style.css')}}">
    <link rel="stylesheet" href="{{asset('css\custom.css')}}">
    {{-- swiper --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.2.6/css/swiper.min.css"> --}}
    <link rel="stylesheet" href="{{asset('css\swiper.min.css')}}">

    <link rel="stylesheet" href="{{asset('css\style.css')}}">

  <script>
    console.log = function() {}
  </script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('styles')
  </head>
  <body>
    <div class="header-full">
      <header class="container mb-0">
        <div class="row">
          <nav class="navbar navbar-expand-lg navbar-light navbar-red mb-0 pb-0 pt-0 col-12">
            <a class="navbar-brand" href="/dashboard">
               <img src="{{asset('images\logo.png')}}">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ Request::path() == 'dashboard' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('frontend.dashboard') }}">Dashboard <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown {{ (Request::path() == 'outputs/maternal' || Request::path() == 'outputs/child') ? 'active' : '' }}">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Outputs
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item {{ Request::path() == 'outputs/maternal' ? 'active' : '' }}"
                    href="{{ route('frontend.outcomes.maternal') }}">Maternal</a>
                    <a class="dropdown-item {{ Request::path() == 'outputs/child' ? 'active' : '' }}" href="{{ route('frontend.outcomes.child') }}">Child</a>
                  </div>
                </li>
                <li class="nav-item {{ Request::path() == 'impacts' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('frontend.impacts') }}">Impacts</a>
                </li>

              </ul>
                <!-- <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form> -->
            </div>
          </nav>
        </div>
      </header>
    </div> {{-- /.header-full --}}
    @yield('content')


    <!-- Latest compiled and minified JavaScript -->
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>  --}}
    <script src="{{asset('js\jquery-3.3.1.min.js')}}"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> --}}
    <script src="{{asset('js\popper.min.js')}}"></script>

    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> --}}
    <script src="{{asset('js\bootstrap.min.js')}}"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script> --}}
    <script src="{{asset('js\Chart.min.js')}}"></script>

    {{-- d3 js added --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.0/d3.js"></script> --}}
    <script src="{{asset('js\d3.js')}}"></script>
    <script type="text/javascript" src="{{asset('js\radial-progress-chart.js')}}"></script>
    {{-- for element animation --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.4/TweenMax.min.js"></script> --}}
    <script src="{{asset('js\TweenMax.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('js\hammer.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js\chart-plugin-zoom.min.js')}}"></script>

    <script>
      @yield('injavascript')
    </script>

    @yield('outjavascript')
  </body>
</html>
