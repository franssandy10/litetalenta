<!--
<ul id="services" class="dropdown-content">
  <li><a href="#!">Update</a></li>
  <li><a href="{!! route('logout') !!}">Log out</a></li>

</ul>
<nav class="white" role="navigation">
  <div class="nav-wrapper container">
    <a id="logo-container" href="#" class="brand-logo">TALENTA MALAYSIA</a>

    <ul class="right hide-on-med-and-down">
      <li><a href="{!! route('employeeindex') !!}">List Employee</a></li>
      <li><a href="#">Run Payroll</a></li>
      <li><a class="dropdown-button" href="#!" data-activates="services">{{ isset(Auth::user()->name) ? Auth::user()->name :'' }}<i class="material-icons right">arrow_drop_down</i></a></li>
    </ul>
    <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
  </div>
</nav>
-->
<div class="navbar-fixed navbar-landing landing">
    <nav>
        <div class="nav-wrapper container">
          <a href="#sidr" id="side-menu" class="hide-on-large-only left"><i class="mdi-navigation-menu white-text"></i></a>
          <a href="#" class="brand-logo"><img id="main-logo" src="assets/images/talenta-logo-white.png" width="150" class="mt10"></a>
          <ul id="nav-mobile" class="right hide-on-med-and-down valign-wrapper">
            <li><a class="lato-black ls2 f11 text-uppercase" href="#!">Tour</a></li>
            <li><a class="lato-black ls2 f11 text-uppercase" href="#!">Pricing</a></li>
            <li><a href="{!! route('login')!!}" class="lato-black ls2 f11 text-uppercase">login</a></li>
            <li><a class="lato-black ls2 f11 text-uppercase btn btnB01 white-text bWhite mtm10" href="{!! route('getstarted.one')!!}">Register</a></li>
          </ul>
          <!-- <a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi-navigation-menu"></i></a> -->
        </div>
    </nav>
</div>

<div id="sidr" class="displayNone">
  <!-- Your content -->
  <ul>
    <li><a class="lato-black ls2 f11 text-uppercase" href="#!">Tour</a></li>
    <li><a class="lato-black ls2 f11 text-uppercase" href="#!">Pricing</a></li>
    <li><a href="{!! route('login')!!}" class="lato-black ls2 f11 text-uppercase">login</a></li>
    <li><a class="lato-black ls2 f11 text-uppercase" href="{!! route('getstarted.one')!!}">Register</a></li>
  </ul>
</div>
