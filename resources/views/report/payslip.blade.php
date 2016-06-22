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
@include('layouts.headers.general')
	<div class="container mt30">
		<div class="row">
			<div class="col l6 m12 s12 right-align left-align-med-and-down">
				<p class="lato-bold f22 red1-text">Rizki Andrianto</p>
				<p class="lato-black text-uppercase ls2 f13">PT. Talenta Digital Indonesia</p>
				<p>Web Developer | Employee ID: TDI-005</p>
			</div>
			<div class="col l6 m12 s12">
				<p class="lato-italic mt5 red1-text bold lineHeightNormal">Basic Salary</p>
				<p class="lato-black f20 lineHeightNormal">IDR 14,000,000</p>
				<P>Working Day: 25, End Month Working Day: 25</P>
			</div>
		</div>
		<div class="row">
			<div class="flexbox col l12 m12 s12">
			  <div class="flex">
			  	<p class="f16 red1-text lato-bold text-uppercase ls2">Allowance</p>
			  	<div class="row mt20">
			  		<div class="clearfix">
				  		<p class="col l6 m6 s12 truncate bold">Tunjangan Makan hsadjhjd ashdjkashdjk ashdjksh</p>
				  		<p class="col l6 m6 s12 right-align">3.000.000</p>
			  		</div>
			  		<div class="clearfix">
				  		<p class="col l6 m6 s12 truncate bold">Tunjangan Makan hsadjhjd ashdjkashdjk ashdjksh</p>
				  		<p class="col l6 m6 s12 right-align">3.000.000</p>
			  		</div>
			  		<div class="clearfix">
				  		<p class="col l6 m6 s12 truncate bold">Tunjangan Makan hsadjhjd ashdjkashdjk ashdjksh</p>
				  		<p class="col l6 m6 s12 right-align">3.000.000</p>
			  		</div>
			  	</div>
			  	<div class="row total">
			  		<p class="col l6 m6 s12 truncate bold">Total Allowance</p>
			  		<p class="col l6 m6 s12 right-align">300.000</p>
			  	</div>
			  </div>
			  <div class="flex">
			  	<p class="f16 red1-text lato-bold text-uppercase ls2">Deduction</p>
			  	<div class="row mt20">
			  		<div class="clearfix">
				  		<p class="col l6 m6 s12 truncate bold">Tunjangan Makan hsadjhjd ashdjkashdjk ashdjksh</p>
				  		<p class="col l6 m6 s12 right-align">3.000.000</p>
			  		</div>
			  	</div>
			  	<div class="row total">
			  		<p class="col l6 m6 s 12 truncate bold">Total Deduction</p>
			  		<p class="col l6 m6 s12 right-align">300.000</p>
			  	</div>
			  </div>
			</div>
		</div>

		<div class="row pad-1-rem pad-t-none pad-b-none">
			<div class="col l12 m12 s12 bgRed1 pad-t-20 pad-b-20 white-text">
				<p class="col l6 m6 s12 lato-light f18">Take Home Pay</p>
				<p class="col l6 m6 s12 right-align lato-black f18">2,495, 940</p>
			</div>
		</div>
	</div>
@endsection