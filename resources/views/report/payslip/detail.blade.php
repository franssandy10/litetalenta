@extends('layouts.app')
@include('employee.reactEmployee')
@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
 @endsection

@section('customCss')
	{!! Html::style('assets/css/stylePayslip.css')!!}
	
@endsection
@section('customjs')

@endsection

@section('content')
	<div class="container mt30">
		<p class="lato-black f27 mb30">Payslip</p>
		<div class="row">
			<div class="col s12">
				<div class="col s12 divSettingResponsive">
					<div class="row h-tabRow">
						<div class="col l12 white pad-40 h-tabRow">
							<div class="settingDiv">
								<p class="titleB01 mb0">February 2016</p>
								<p class="lato-black f20">{{$result->first_name . ' ' . $result->last_name}}</p>
								<p class="f16 lato-bold">{{$result->employee_id}}</p>
								<p class="f16 lato-bold">Job Position</p>

								<!-- Basic Salary -->
								<div class="row mt30 pad-t-20 pad-b-20 bBottom">
									<div class="col l3 m3 s12">
										<p class="red1-text lato-black">Salary</p>
									</div>
									<div class="col l9 m9 s12 pad-r-n">
										<div class="col s7 noPadResponsive">
											<p class="lato-black">Basic Salary</p>
										</div>
										<div class="col s5 right-align noPadResponsive">
											<p>{{number_format($result->latestEmployeePayroll()->basic_salary,2,'.','.')}}</p>
										</div>
									</div>
								</div><!-- Basic Salary -->

								<!-- Allowance -->
								<div class="row pad-b-20 bBottom">
									<div class="col l3 m3 s12">
										<p class="red1-text lato-black">Allowance</p>
									</div>
									<div class="col l9 m9 s12 pad-r-n">
										<div class="component">
											<div class="col s7 noPadResponsive">
												<p class="lato-black">Tax Allowance</p>
											</div>
											<div class="col s5 right-align noPadResponsive">
												<p>{{number_format($detail_payroll->tax_allowance,2,'.',',')}}</p>
											</div>
										</div>
										
										<!-- Total Allowance -->
										<div class="col s7 bTop noPadResponsive">
											<p class="lato-black">Total Allowance</p>
										</div>
										<div class="col s5 bTop right-align noPadResponsive">
											<p>{{number_format($total['allowance'],2,'.',',')}}</p>
										</div>
									</div>
								</div><!-- Allowance -->


								<!-- Deduction -->
								<div class="row pad-b-20 bBottom mb10">
									<div class="col l3 m3 s12">
										<p class="red1-text lato-black">Deduction</p>
									</div>
									<div class="col l9 m9 s12 pad-r-n">
										<div class="component">
											<div class="col s7 noPadResponsive">
												<p class="lato-black">BPJSK Employee</p>
											</div>
											<div class="col s5 right-align noPadResponsive">
												<p>{{number_format($detail_payroll->bpjsk_employee,2,'.',',')}}</p>
											</div>
										</div>

										<div class="component">
											<div class="col s7 noPadResponsive">
												<p class="lato-black">JHT Employee</p>
											</div>
											<div class="col s5 right-align noPadResponsive">
												<p>{{number_format($detail_payroll->jht_employee,2,'.',',')}}</p>
											</div>
										</div>


										<div class="component">
											<div class="col s7 noPadResponsive">
												<p class="lato-black">Jaminan Pensiun Employee</p>
											</div>
											<div class="col s5 right-align noPadResponsive">
												<p>{{number_format($detail_payroll->jp_employee,2,'.',',')}}</p>
											</div>
										</div>

										<div class="component">
											<div class="col s7 noPadResponsive">
												<p class="lato-black">PPH 21</p>
											</div>
											<div class="col s5 right-align noPadResponsive">
												<p>{{number_format($detail_payroll->pph_monthly,2,'.',',')}}</p>
											</div>
										</div>
										
										<!-- Total Deduction -->
										<div class="col s7 bTop noPadResponsive">
											<p class="lato-black">Total Deduction</p>
										</div>
										<div class="col s5 bTop right-align noPadResponsive">
											<p>{{number_format($total['deduction'],2,'.',',')}}</p>
										</div>
									</div>
								</div><!-- Deduction -->

								
								<div class="row pad-t-none pad-b-none">
									<div class="col l12 m12 s12 thpDiv bgRed1 pad-t-10 pad-b-10 white-text noPadResponsive">
										<p class="lato-light left">Take Home Pay</p>
										<p class="right-align right">{{number_format($total['takehomepay'],2,'.',',')}}</p>
									</div>
								</div>
							</div><!-- SettingDiv -->
						</div>
					</div>
				</div>
			</div>
		</div>

		
	</div>
@endsection
