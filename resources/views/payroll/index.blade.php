@extends('layouts.app')
@include('employee.reactEmployee')
@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
 @endsection

@section('customCss')
@endsection
@section('customjs')

@endsection
@section('content')
	<div class="container mt30 center-align">
		<h1 class="titleC01">Welcome to Talenta Payroll Software</h1>
		<h5 class="subtitleB01">PT. Talenta Digital Indonesia</h5>

		<div class="row">
			<div class="row">
				<!-- Row 1 -->
				<div class="col s12 m4">
					<a href="#modalRunPayroll" class="modal-trigger modal-post" >
						<div class="card-panel payrollItem payrollItem3 hoverable" href="#!">
						  <span class="white-text">Run<br>Payroll
						  </span>
						</div>
					</a>
				</div>

				<div class="col s12 m4">
					<a href="{{ route('settingpayrollconfig')}}">
					    <div class="card-panel payrollItem payrollItem4 hoverable">
					      <span class="white-text">Configure<br>Payroll
					      </span>
					    </div>
					</a>
				</div>

				<div class="col s12 m4">
					<a href="{{ route('payrollcomponenttrxadjust')}}">
					    <div class="card-panel payrollItem payrollItem1 hoverable">
					      <span class="white-text">Payroll<br>Changes
					      </span>
					    </div>
					</a>
				</div>

				<div class="col s12 m4">
					<a href="#!">
					    <div class="card-panel payrollItem payrollItem5 hoverable">
					      <span class="white-text">Import<br>Payroll
					      </span>
					    </div>
					</a>
				</div>


				<!-- Row 2 -->
				<div class="col s12 m4">
					<a href="{!! route('reimbursement.index') !!}">
						<div class="card-panel payrollItem payrollItem2 hoverable" href="#!">
						  <span class="white-text">Reimbursement
						  </span>
						</div>
					</a>
				</div>

				<div class="col s12 m4">
					<a href="{{route('reportindex',['month'=>date('m'),'year'=>date('Y')])}}">
					    <div class="card-panel payrollItem payrollItem7 hoverable">
					      <span class="white-text">View<br>Report
					      </span>
					    </div>
					</a>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Run Payroll -->
	<div id="modalRunPayroll" class="modal modal-fixed-footer modal-confirm maxHeight340">
    {!! Form::open(array('route' => 'payrolldate')) !!}
		<div class="modal-content">
		  <h4 class="titleB01">Run Payroll Period</h4>
		  <div class="row">
		  	<div class="col s12 input-field">
          <?= Form::select('month', BaseService::getMonth(),date('m'),['class'=>'validate enter_disabled']); ?>
		  		<label>Month</label>
		  	</div>
		  	<div class="col s12 input-field">
          <?= Form::select('year', BaseService::getYear(),'',['class'=>'validate enter_disabled']); ?>
		  		<label>Year</label>
		  	</div>
		  </div>
		</div>
		<div class="modal-footer">
			   <a href="#!" class="modal-action modal-close btn btnB01">Cancel</a>
		  	<a href="#!" class="modal-action modal-close btn btnB01 submitButton">Confirm</a>
		</div>
    {!! Form::close()!!}
	</div>
@endsection
