@extends('layouts.app')

@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
@endsection

@section('customCss')
	{!! Html::style('assets/css/style-setting.css')!!}
	{!! Html::style('assets/plugins/dataTable/datatables.min.css')!!}
	<style type="text/css">
		.tab-content {
			min-height:480px;
		}
	</style>
@endsection


@section('content')

	<div class="container mt30">
		<div class="row">
			<div class="col s12">
				<p class="titleB01 black-text">Payroll Configuration</p>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row h-tabRow">
		    <div class="col l2 pad-r-n pad-l-n">
		      <ul class="tabs tab-horizontal">
		      	<li class="tab col l12"><a href="#payrollConf"><i class="talenta-payroll-details fa-2x mb20"></i>payroll<br>detail</a></li>
		        <li class="tab col l12"><a href="#cutoff"><i class="talenta-kalkulator-2 fa-3x mb20"></i>cut off</a></li>
		        <li class="tab col l12"><a href="#payrollComponent"><i class="talenta-komponen fa-3x mb20"></i>payroll<br>component</a></li>
		      </ul>
		    </div>

		    <!-- tab-content -->
		    <div class="col l10 white pad-l-n h-tabRow">
				<div id="payrollConf" class="col l12 pad-20 tab-content">
					<div class="row" id="row1">
			    		<p class="titleB01 mb30">Payroll Details</p>

			    		@include('payroll/partial/detail')
			    		<a href="#!" class="btn btnB01 right mt30 configButton" attr-row="row1">Save</a>
			    	</div>
				</div>

				<!-- Cut Off -->
			    <div id="cutoff" class="col l12 pad-20 tab-content">

			    	<div class="row" id="row2">
			    		<p class="titleB01 mb30">Cut Off</p>


			    		<!-- <div class="col l2">
			    			<p class="subtitleA01 red1-text mt15">cut off</p>
			    		</div>
			    		<div class="col l4 input-field mt0">
			    			<input type="checkbox" class="filled-in" id="defaultCutOff">
			    			<label for="defaultCutOff">Default</label>
			    		</div>
			    		<div class="clearfix"></div> -->
			    		@include('payroll/partial/cutoff')
			    		<div class="col l12 right-align mt30">
			    			<a href="#!" class="btn btnB01 configButton" attr-row="row2">save</a>
			    		</div>
			    	</div>
			    </div>

			    <!-- payroll component -->
			    <div id="payrollComponent" class="col l12 pad-20 tab-content">
		    		<div class="row">
		    			<p class="titleB01 mb30">Payroll Component</p>

		    		</div>
			    	<div class="row">
			    		@include('payroll.partial.component')
			    	</div>
			    </div>

			    <!-- prorate -->
			    <!-- <div id="prorate" class="col l12 pad-20 tab-content">
			    	<div class="row">
			    		<p class="titleB01 mb30">Pro-rate Setting</p>

		    			@include('payroll.partial.prorate')
			    	</div>
			    </div> -->

			    <!-- absennce -->
			    <!-- <div id="absence" class="col l12 pad-20 tab-content">
			    	<div class="row">
			    		<p class="titleB01 mb30">Absence Setting</p>

		    			@include('payroll.partial.absence')
			    		<div class="col l12 right-align input-field">
			    			<a href="#!" class="btn btnB01">save</a>
			    		</div>
			    	</div>
			    </div> -->

			    <!-- thr -->
			    <!-- <div id="thr" class="col l12 pad-20 tab-content">
			    	<div class="row">
			    		<p class="titleB01 mb30">(THR) Tunjangan Hari Raya Setting</p>

			    		@include('payroll.partial.thr')

			    		<div class="col l12 right-align">
			    			<a href="#!" class="btn btnB01 mt20">save</a>
			    		</div>
			    	</div>
			    </div> -->
		    </div>
		</div>
	</div>
@include('payroll.component.create-modal')
@endsection
@section('customjs')
	{!! Html::script('assets/plugins/dataTable/datatables.min.js')!!}
	@yield('createcompjs')
	<script type="text/javascript">
		$(document).ready(function(){
	      $('.configButton').click(function(){
	        $form=$('#'+$(this).attr('attr-row')).find('form');
	        validateForm($form);
	      })
	    })
	</script>
@endsection
