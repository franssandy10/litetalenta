<!-- Header -->
<div class="navbar-fixed">
    <nav class="logged-in">
      <div class="nav-wrapper">
        <div class="container">
          <a href="#sidr" id="side-menu" class="hide-on-large-only left"><i class="mdi-navigation-menu white-text"></i></a>
          <a href="{{route('index')}}" class="brand-logo hide-on-small-only"><img src="{{asset(config('param.url_images').'talenta-logo.png')}}" width="144"></a>
          <a href="{{route('index')}}" class="brand-logo hide-on-med-and-up"><img src="{{asset(config('param.url_images').'talenta-logo-white.png')}}" width="144"></a>
          <ul class="right hide-on-med-and-down">
            <li class="overflowHidden">
            <a href="{{ route('message')}}" class="iconNav"><i class="fa fa-envelope"></i>
            @if (MessageService::countAllUnreadMessage() > 0)
              <span class="notifIcon">{{MessageService::countAllUnreadMessage()}}</span>
            @endif
            </a>
            </li>
            <!-- <li><a href="sass.html" class="iconNav"><i class="fa fa-question-circle iconHeader"></i></a></li> -->
            <li>
              <a class="dropdown-button headerDropdown" href="#!" data-activates="dropdown1" data-belowOrigin="true" data-constrainWidth="false" data-hover="true" data-toggle="true">
                <img class="circle responsive-img iconAvatar" width="20" src="{{Sentinel::getUser()->userAccessConnection->getAvatar()}}"/>
                  {{ UserService::getFullName()}}
                <i class="mdi-navigation-arrow-drop-down right"></i>
              </a>
            </li>
              <!-- Dropdown Structure -->
            <ul id='dropdown1' class='dropdown-content'>
              <li><a href="{{ route('settingpersonal')}}">Settings</a></li>
              <li><a href="#!">FAQs</a></li>
              <li><a href="#!">Need Support?</a></li>
              <li class="divider"></li>
              <li><a href="{{ route('logout')}}">Sign Out</a></li>
            </ul>
          </ul><!-- right hide-on-med-and-down -->
        </div><!-- container -->
      </div><!-- nav-wrapper -->
    </nav>
</div><!-- navbar-fixed -->

<!-- MENU ON DESKTOP -->
<div class="nav2 hide-on-med-and-down">
  <nav class="nav2">
    <div class="nav-wrapper">
      <div class="container center-align">
        <ul id="nav-mobile" class="right hide-on-small-only center-align-med displayInlineBlock">
          <li><a href="{{ route('dashboard')}}">Dashboard</a></li>
          @if (UserService::getUserEmployee() === true)
            <li><a href="{!! route('myinfoindex') !!}">My Info</a></li>
          @endif
          @if(Sentinel::getUser()->getRoles()[0]->name=='Super Admin')
          <li><a href="{!! route('employeeindex') !!}">Employees</a></li>
          @endif
          <li><a href="{!! route('timeoff') !!}">Time Off</a></li>
          <li><a href="{!! route('reimbursement.index') !!}">Reimbursement</a></li>
          @if(Sentinel::getUser()->getRoles()[0]->name=='Super Admin')
            @if(UserService::runPayrollStatus())
              <li><a href="{!! route('payrollindex') !!}">Payroll</a></li>
            @else
              <li><a href="{!! route('payrollconfigure') !!}">Set Payroll</a></li>
            @endif
          @endif
          <!-- <li><a>Tasks</a></li> -->
        </ul>
      </div>
    </div>
  </nav>
</div>
<!-- MENU ON DESKTOP -->

<!-- Sidebar -->
<div id="sidr" class="displayNone">
  <!-- Your content -->
  <ul>
    <li><a href="{{ route('dashboard')}}">Dashboard</a></li>
    <li><a href="{{ route('message')}}">Inbox</a></li>
    <li><a href="{!! route('myinfoindex') !!}">My Info</a></li>
    <li><a href="{!! route('timeoff') !!}">Time Off</a></li>
    <li><a href="{!! route('reimbursement.index') !!}">Reimbursement</a></li>
    @if(Sentinel::getUser()->getRoles()[0]->name=='Super Admin')
    <li><a href="{!! route('employeeindex') !!}">Employees</a></li>
    @if(UserService::runPayrollStatus())
      <li><a href="{!! route('payrollindex') !!}">Payroll</a></li>
    @else
      <li><a href="{!! route('payrollconfigure') !!}">Set Payroll</a></li>
    @endif
    @endif
    <!-- <li><a>Tasks</a></li> -->
    <hr>

    <li><a href="{{ route('settingpersonal')}}">Settings</a></li>
    <li><a href="#!">FAQs</a></li>
    <li><a href="#!">Need Support?</a></li>
    <li class="divider"></li>
    <li><a href="{{ route('logout')}}">Sign Out</a></li>
  </ul>
</div>
