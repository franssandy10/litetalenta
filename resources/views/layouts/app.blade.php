<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="theme-color" content="#910111">
  <!-- <link rel="shortcut icon" href="http://i572.photobucket.com/albums/ss170/accel-design/favicon.gif"/> -->
  <link rel="shortcut icon" href="http://talenta.co/assets/images/favicon.png"/>

  <title>Talenta Lite</title>

  <!-- CSS  -->
  @section('css')
    @include('layouts.css')
  @show
</head>
<body {{{ Request::path() == "/" ? 'id=bgLanding' : 'Default' }}}>
  @yield('navbar')
  @yield('content')
  @yield('footer')
  @yield('url-ajax')
  <!-- Modal Loading -->
  <div id="modalLoading" class="modal modal-fullscreen bgGreyTransparent white-text">
    <div class="valign-wrapper h100vh">
      <div class="valign center-align w100p">
        <div class="loading">
          <div class="sk-cube-grid">
            <div class="sk-cube sk-cube1"></div>
            <div class="sk-cube sk-cube2"></div>
            <div class="sk-cube sk-cube3"></div>
            <div class="sk-cube sk-cube4"></div>
            <div class="sk-cube sk-cube5"></div>
            <div class="sk-cube sk-cube6"></div>
            <div class="sk-cube sk-cube7"></div>
            <div class="sk-cube sk-cube8"></div>
            <div class="sk-cube sk-cube9"></div>
          </div>
          <p class="lato-light f30">Loading, Please Wait...</p>
        </div>
      </div>
    </div>
  </div>
</body>
  <!--  Scripts-->
  @section('scripts')
  @include('layouts.scripts')
  @show
</html>
