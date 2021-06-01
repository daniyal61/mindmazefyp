<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/ico" href="{{asset('/images/logo/'. $setting->favicon)}}">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <!--[if IE]>
    <link rel="shortcut icon" href="/favicon.ico" type="image/vnd.microsoft.icon">
    <![endif]-->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{$setting->welcome_txt}}</title>

    <!-- Styles -->
    @yield('head')
<style type="text/css">
    
body {
  font-family: "Poppins", sans-serif;
  height: 100vh;/*
  background: url('https://cdn.gamedevmarket.net/wp-content/uploads/20191203165901/419c763aae13d8180f81c8cc8bb7edd6.png');*/


  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;


  top: 0;

  left: 0;

  bottom: 0;

  right: 0;

  

  z-index: -1;   
}
</style>

</head>
<body >
  <style>
    .loader {
      position: fixed;
      z-index: 99999;
      width: 100%;
      height: 100%;
      text-align: center;
      align-items: center;
      background: #ffffffa6;
    }
  
    .loader img {
      display: block;
      margin: auto;
      margin-top: 16%;
    }
  </style>
  <div class="loader">
    <img src="{{asset('loader.gif')}}">
  </div>
    <div id="app" style="position: relative;">
  <nav class="navbar navbar-default navbar-static-top" >
    <div class="nav-bar">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="navbar-header">
              <!-- Branding Image -->
              @if($setting)
                <a class="tt" title="Quick Quiz Home" href="{{url('/')}}">
                  <img src="{{ asset('images/logo.png') }}" style="width:80px">
                </a>
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
              
            <ul class="nav navbar-nav navbar-right">
              
                @guest
                  <li><a href="{{ route('login') }}" title="Login">Login</a></li>
                  <li><a href="{{ route('register') }}" title="Register">Register</a></li>
                @else
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                      {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                      @if ($auth->role == 'A')
                        <li><a href="{{url('/admin')}}" title="Dashboard">Dashboard</a></li>
                      @elseif ($auth->role == 'S')
                        <li><a href="{{url('/admin/my_reports')}}" title="Dashboard">Dashboard</a></li>
                      @endif
                      <li>
                        <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        Logout
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                      </form>
                      </li>
                    </ul>
                  </li>
                 
                @endguest
          
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
        @yield('content')
        <br>
        <br>
    </div>
    @php
     $ct = App\copyrighttext::where('id','=',1)->first();
    @endphp
   <div style="padding:15px;color: #FFF;background-color:#424242; position: fixed; width: 100%; bottom: 0;display: none;">
        <div class="container" >
            <div class="row">
                <div class="col-md-6">
                    {{ $ct->name }}
                </div>
                <div class="col-md-6">
                    @php
                    $si = App\SocialIcons::all();
                    @endphp
                    @foreach($si as $s)
                    @if($s->status==1)
                        <a target="_blank" title="Visit {{ $s->title }}" href="{{ $s->url }}"><img width="32px" src="{{ asset('images/socialicons/'.$s->icon) }}" alt="{{ $s->title }}" title="{{ $s->title }}" style="margin-top:-5px;"></a>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
    <script>
      setInterval(function(){
      $('.loader').hide();
      },2000);
    </script>
</body>
</html>
