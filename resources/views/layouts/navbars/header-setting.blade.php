<?php
	$url = Request::path();
?>
<div class="container mt20">
	<p class="titleB01">Settings</p>
	<div class="row mt30">
		<nav class="nav3">
	      	<div class="nav-wrapper">
	        <ul id="nav-mobile">
				<li class="{{($url == 'setting/personal') ? 'active' : ''}}"><a href="{{ route('settingpersonal')}}">Personal</a></li>
				@if(Sentinel::getUser()->getRoles()[0]->name=='Super Admin')
				<li class="{{($url == 'setting/useraccess') ? 'active' : ''}}"><a href="{{ route('settinguseraccess')}}">Users</a></li>
				<li class="{{($url == 'setting/recommendation') ? 'active' : ''}}"><a href="{{ route('settingrecommendation')}}">Recommendation</a></li>

				<li class="{{($url == 'setting/company-information' || $url == 'setting/company-configuration' || $url == 'setting/payroll-configuration' || $url == 'setting/ess-configuration' ) ? 'active' : ''}}"><a class="dropdown-button headerDropdown" href="#!" data-activates="dropdownSetting" data-beloworigin="true" data-constrainwidth="false" data-hover="true" data-toggle="true">Configuration<i class="mdi-navigation-arrow-drop-down right"></i></a>
					<ul id="dropdownSetting" class="dropdown-content">
						@if(UserService::runPayrollStatus())
						<li><a href="{{ route('settingcompanyinfo')}}">Company Information</a></li>
						<li><a href="{{ route('settingpayrollconfig')}}">Payroll Configuration</a></li>
						@endif
						<li><a href="{{ route('settingcompanyconfig')}}">Company Configuration</a></li>
					</ul>
				</li>

				@endif
				<!-- Dropdown Structure -->

			</ul>
	      	</div>
	    </nav>
	</div>
</div>
