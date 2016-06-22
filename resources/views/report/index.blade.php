@extends('layouts.app')
@include('employee.reactEmployee')
@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
 @endsection

@section('customCss')
	{!! Html::style('assets/css/style-setting.css')!!}
@endsection

@section('content')
<?php if ($total_employee_payroll) { ?>
@include('layouts.headers.general')
	<div class="container mt30">
		<div class="row">
			<div class="col l2 m2 s12 input-field">
        <?= Form::select('month', BaseService::getMonth(),$month,['id'=>'monthfilter','class'=>'validate enter_disabled']); ?>
				<label>Month</label>
			</div>
			<div class="col l1 m1 s12 input-field">
        <?= Form::select('year', BaseService::getYear(),$year,['id'=>'yearfilter','class'=>'validate enter_disabled']); ?>
				<label>Year</label>
			</div>
			<div class="col l2 m2 s12 center-align-down">
				<a id="filterreport" class="btn btnB01 mt15">Submit</a>
			</div>
		</div>

		<div class="row">
		    <div class="col l4 m6 s12 hide-on-small-and-down">
		      <ul class="tabs tab-horizontal payrollTab reportTab">
		        <li class="tab col s12 left-align active"><a href="#salaryReport">Salary Report</a></li>
		        <li class="tab col s12 left-align"><a href="#taxReport">Tax Report</a></li>
		      </ul>
		    </div>

		    <div class="s12 hide-on-med-and-up">
			    <div class="col s12 input-field mb20">
			    	<select id="reportType">
				    	<option value="salaryReport">Salary Report</option>
				    	<option value="taxReport">Tax Report</option>
				    </select>
				    <label>Select Report</label>
			    </div>
		    </div>

		    <div class="col l6 m6 s12 salaryReportTab">
		        <!-- salary report Tab -->
		        <div id="salaryReport" class="col l12 m12 s12 pad-20 grey lighten-3">
		        	<p><a class="bold red1-text" href="{{route('report.salarydetail',['month'=>$month,'year'=>$year])}}">Salary Detail</a></p>
		        	<p><a class="bold red1-text" href="{{route('reportpayslip',['month'=>$month,'year'=>$year])}}">Payslip</a></p>
		        </div>

		        <!-- tax report Tab -->
		        <div id="taxReport" class="col l12 m12 s12 pad-20 grey lighten-3">
		        	<p><a class="bold red1-text" href="{{route('reporttax1721a1')}}">Form 1721-A1</a></p>
		        </div>
			 
		    </div>
		</div>
	</div>
<?php } else { ?>
	<div class="container mt30">
		<div class="row">
			<div class="col l12 m12 s12 grey white-text center-align pad-40">
				<p class="text-uppercase ls3 lato-black">In order to view report, you need to run payroll first</p>
				<a href="javascript:history.back()" class="btn btnB01 white-text bWhite mt30 mr5">Back</a>
				<a href="{{route('payrollindex')}}" class="btn btnB01 white-text bWhite mt30">RUN PAYROLL</a>
			</div>
		</div>
	</div>
<?php } ?>
@endsection

@section('customjs')
<script>
  $(document).ready(function(){
    $("#filterreport").click(function(){
        window.location.href="{{route('index')}}"+"/report/"+$("#monthfilter").val()+"/"+$('#yearfilter').val();
    });

    $('#reportType').change(function(){
    	materialSelect()
    	$('.payrollTab a[href="#' + $(this).val() + '"]').click()
    })

  })
</script>
@endsection