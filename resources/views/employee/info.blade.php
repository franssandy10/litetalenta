@extends('layouts.app')
@include('employee.reactEmployee')
@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
 @endsection

@section('customjs')
  {!! Html::script('assets/plugins/jquery.bxslider/jquery.bxslider.min.js')!!}
	{!! Html::script('assets/plugins/dataTable/datatables.min.js')!!}
	{!! Html::script('assets/js/scriptDataTable.js')!!}
@endsection

@section('customCss')
	{!! Html::style('assets/plugins/jquery.bxslider/jquery.bxslider.css')!!}
	{!! Html::style('assets/plugins/dataTable/datatables.min.css')!!}
	<style type="text/css">
		.dashboard-amountLeave {
			display: inline-block;
			font-family: 'lato-regular';
			font-size: 50px;
			color: rgb(216, 215, 215);
			margin:0;
		}

		.dashboard-daysLeave {
			display: inline-block;
			font-size: 15px;
			margin: 0;
			color: rgb(139, 139, 139);
			font-family: 'lato-italic';
		}

		.dashboard-leave {
			font-family: 'lato-black';
			clear: both;
			font-size: 13px;
			text-transform: uppercase;
			letter-spacing: 2px;
			color: rgb(99, 99, 99);
			margin: 5px 0 0px;
		}
		.slider .slide {
			border-right: 1px solid #aaa;
			padding: 20px 0;
			text-align: center;
		}

		.tabs .tab {
			min-width: 120px;
		}
	</style>
@endsection
@include('employee/info/employment-data')
@include('employee/info/personal-data')
@if ($status_payroll=== true)
	@include('employee/info/payroll-data')
@endif

@section('content')
<div class="container mt30 my-info">
	<div class="row">
	    <div class="col s12 my-info">
	      <ul class="tabs my-info no-indicator">
	        <li class="tab col s4"><a href="#generalInfo"><i class="talenta-orang-3 displayInlineBlock mr5 hide-on-med-and-down"></i>General Info</a></li>
			@if ($status_payroll=== true)
	        	<li class="tab col s4"><a href="#payrollInfo"><i class="talenta-kalkulator-1 displayInlineBlock mr5 hide-on-med-and-down"></i>Payroll Info</a></li>
	        @endif
	        <li class="tab col s4"><a href="#timeoff"><i class="talenta-kalender-8 displayInlineBlock mr5 hide-on-med-and-down"></i>Time Off</a></li>
	        <!-- <li class="tab col s4"><a href="#overtime"><i class="talenta-kalender-8 displayInlineBlock mr5 hide-on-med-and-down"></i>Overtime</a></li>
	        <li class="tab col s4"><a href="#delegation"><i class="talenta-kalender-8 displayInlineBlock mr5 hide-on-med-and-down"></i>Delegation</a></li>
	        <li class="tab col s4"><a href="#history"><i class="talenta-kalender-8 displayInlineBlock mr5 hide-on-med-and-down"></i>History</a></li>
	        <li class="tab col s4"><a href="#assets"><i class="talenta-kalender-8 displayInlineBlock mr5 hide-on-med-and-down"></i>Assets</a></li> -->
	      </ul>
	    </div>

	    <!-- General Info -->
	    <div id="generalInfo" class="tab-content white">
  			<div class="col l12 m12 s12">

  				<div class="row mt30 mr0 ml0">
  		    		<div class="col l12 m12 s12">
  			    		<p class="titleC01 mb40 noBold mt30 left mr15">Add, edit, or delete information about an employee</p>
  			    		<a href="#!" class="btn btnB01 left mt40">Request time off</a>
  		    		</div>
  	    		</div>

  				<div class="row mt30 mr0 ml0">
  				  	<div class="col l12 m12 s12">
  				    	<ul style="width: 100%;" class="tabs my-info2 no-indicator">
  				            <li class="tab col s4"><a href="#employmentData">EMPLOYMENT DATA</a></li>
  				            <li class="tab col s4"><a href="#personalData">PERSONAL DATA</a></li>
  				      		<!-- <li class="tab col s3"><a href="#performance">PERFORMANCE</a></li> -->
  				      		<!-- <li class="tab col s4"><a href="#familyInfo">FAMILY INFO</a></li> -->
  				      	</ul>
  				  	</div>
  				</div>


          @yield('employmentDataHtml')
          @yield('personalDataHtml')


  				<!-- <div id="familyInfo" class="col l12 m12 s12 pad-20 white">
  					<h5 class="ml10">Family Data <a href="#!" class="btn btnB01 ml5">Add New</a></h5>
  					<div class="col l12 m12 s12 mb40 tableWrap">
  						<table class="bordered">
  							<thead class="grey lighten-3 bold">
  								<tr>
  									<td width="50" class="no-sort">No</td>
  									<td>Full Name</td>
  									<td>Relationship</td>
  									<td>Birth Date</td>
  									<td>No KTP</td>
  									<td>Marital Status</td>
  									<td>Gender</td>
  								</tr>
  							</thead>
  							<tbody>
  								<tr>
  									<td width="50">1.</td>
  									<td>Rizki And</td>
  									<td>Paman</td>
  									<td>12-06-1992</td>
  									<td>3174041260565</td>
  									<td>Single</td>
  									<td>Male</td>
  								</tr>
  							</tbody>
  						</table>
  					</div>
  					<h5 class="ml10 mt40">Emergency Contact <a href="#!" class="btn btnB01 ml5">Add New</a></h5>
  					<div class="clearfix"></div>
  					<div class="col l12 m12 s12 tableWrap">
  						<table class="bordered">
  							<thead class="grey lighten-3 bold">
  								<tr>
  									<td width="50">No</td>
  									<td>Full Name</td>
  									<td>Relationship</td>
  									<td>Birth Date</td>
  									<td>No KTP</td>
  									<td>Marital Status</td>
  									<td>Gender</td>
  								</tr>
  							</thead>
  							<tbody>
  								<tr>
  									<td></td>
  									<td></td>
  									<td></td>
  									<td></td>
  									<td></td>
  									<td></td>
  									<td></td>
  								</tr>
  							</tbody>
  						</table>
  					</div>
  				</div> -->


  			</div>
	    </div>
      @yield('payrollDataHtml')



	    <!-- Time Off -->
	    <div id="timeoff" class="tab-content white">
	    	<div class="col l12 m12 s12">
	    		<div class="row mr0 ml0">
		    		<div class="col l12 m12 s12">
			    		<p class="titleC01 mb40 noBold mt30 left mr15">Time Off</p>
			    		<a href="#!" class="btn btnB01 left mt40">Request time off</a>
		    		</div>
	    		</div>

				<div class="row">
					<div class="col l12 m12 s12"><!--
						<div class="slider">
							<div class="slide">
						        <p class="dashboard-leave red1-text">Cuti Tahunan</p>
						        <p class="dashboard-amountLeave black-text">3</p>
						        <p class="dashboard-daysLeave hide-on-med-and-down black-text">days</p>
						    </div>
						    <div class="slide">
						        <p class="dashboard-leave red1-text">Cuti Tahunan</p>
						        <p class="dashboard-amountLeave black-text">3</p>
						        <p class="dashboard-daysLeave hide-on-med-and-down black-text">days</p>
						    </div>
						    <div class="slide">
						        <p class="dashboard-leave red1-text">Cuti Tahunan</p>
						        <p class="dashboard-amountLeave black-text">3</p>
						        <p class="dashboard-daysLeave hide-on-med-and-down black-text">days</p>
						    </div>
						    <div class="slide">
						        <p class="dashboard-leave red1-text">Cuti Tahunan</p>
						        <p class="dashboard-amountLeave black-text">3</p>
						        <p class="dashboard-daysLeave hide-on-med-and-down black-text">days</p>
						    </div>
						    <div class="slide">
						        <p class="dashboard-leave red1-text">Cuti Tahunan</p>
						        <p class="dashboard-amountLeave black-text">3</p>
						        <p class="dashboard-daysLeave hide-on-med-and-down black-text">days</p>
						    </div>
						    <div class="slide">
						        <p class="dashboard-leave red1-text">Cuti Tahunan</p>
						        <p class="dashboard-amountLeave black-text">3</p>
						        <p class="dashboard-daysLeave hide-on-med-and-down black-text">days</p>
						    </div>
						    <div class="slide">
						        <p class="dashboard-leave red1-text">Cuti Tahunan</p>
						        <p class="dashboard-amountLeave black-text">3</p>
						        <p class="dashboard-daysLeave hide-on-med-and-down black-text">days</p>
						    </div>
						</div> -->
					</div>
				</div>

				<div class="row mt30 mr0 ml0">
				  	<div class="col l12 m12 s12">
				    	<ul style="width: 100%;" class="tabs my-info2 no-indicator">
				            <li class="tab col s6"><a href="#timeoffReq">Time Off Requested</a></li>
				            <li class="tab col s6"><a href="#timeoffTaken">Time Off Taken</a></li>
				      	</ul>
				  	</div>
				</div>

				<div id="timeoffReq" class="col l12 m12 s12 pad-20 white">
					<div class="row">
						<p class="titleC01 mb40 noBold mt30 mr15">Time Off Requested</p>
			    		<div class="col l12 m12 s12 tableWrap">
			    			<table class="bordered">
			    				<thead class="grey lighten-3 bold">
			    					<tr>
			    						<td>Policy Code</td>
			    						<td>Start Date</td>
			    						<td>End Date</td>
			    						<td>Status</td>
			    						<!-- <td>Action</td> -->
			    					</tr>
			    				</thead>
			    				<tbody>
                    @foreach($list_timeoff_request as $timeoff_request)
			    					<tr>
			    						<td>{{$timeoff_request->policy->policy_code}}</td>
			    						<td>{{$timeoff_request->start_date}}</td>
			    						<td>{{$timeoff_request->end_date}}</td>
                      <td>{{$timeoff_request->approved_flag}}</td>
			    						<!-- <td>1 Day</td> -->
			    						<!-- <td>
			    							<a href="#!" class="red1-text bold mr5" data-tooltip="detail"><i class="fa fa-list"></i></a>
			    							<a href="#!" class="red1-text bold" data-tooltip="cancel"><i class="fa fa-times"></i></a>
			    						</td> -->
			    					</tr>
                    @endforeach
			    				</tbody>
			    			</table>
			    		</div>
					</div>
				</div>

  				<div id="timeoffTaken" class="col s12 pad-20 white">
  					<div class="row">
  						<p class="titleC01 mb40 noBold mt30 mr15">Time Off Taken</p>
  			    		<div class="col l12 m12">
  			    			<table class="bordered tableWrap">
  			    				<thead class="grey lighten-3 bold">
  			    					<tr>
  			    						<td>Policy Code</td>
  			    						<td>Effective Date</td>
  			    					</tr>
  			    				</thead>
  			    				<tbody>
  			    					<tr>
  			    						<td>A360</td>
  			    						<td>2015-10-21</td>
  			    					</tr>
  			    				</tbody>
  			    			</table>
  			    		</div>
  					</div>
  				</div>
	    	</div>
	    </div>
	</div>
</div>
@include('payroll.component.add-modal')
@endsection
