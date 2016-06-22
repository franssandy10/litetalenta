@extends('layouts.app')

@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
@endsection

@section('customCss')
	{!! Html::style('assets/css/style-setting.css')!!}
	{!! Html::style('assets/plugins/dataTable/datatables.min.css')!!}
	<style type="text/css">
		table {
			table-layout: auto !important;
		}
		table.timeOffSetting {
			width: auto
		}
		table.timeOffSetting th,
		table.timeOffSetting td {
			padding: 0 2px;
			text-align: center;
			font-size: 14px;
		}

		table.timeOffSetting th {
			font-size: 12px;
		}

		table.timeOffSetting th:not(.name) {
			width: 60px;
		}

		table.timeOffSetting [type="checkbox"]+label{
			padding-left: 20px;
		}

		table.timeOffSetting input[type="text"] {
			text-align: center;
		}
	</style>
@endsection

@section('customjs')
	{!! Html::script('assets/plugins/dataTable/datatables.min.js')!!}
	<script type="text/javascript">
		$(document).ready(function(){
			var tab = '{!!isset($_GET["tab"]) ? $_GET["tab"] : "" !!}';

			if (tab == 'create') {
				$('ul.tabs').tabs('select_tab', 'timeoff');
				$('#timeOffSetting').hide(100);
				$('#newTimeOffPolicy').show(100);
			}

			$('#addNewPolicy').click(function(){
				$('#timeOffSetting').hide(100);
				$('#newTimeOffPolicy').show(100);
			})
		})
	</script>
@endsection

@section('content')
	@include('layouts.navbars.header-setting')

	<div class="container">
		<div class="row h-tabRow">
		    <div class="col l2 pad-r-n pad-l-n">
		      <ul class="tabs tab-horizontal">
		        <li class="tab col l12"><a href="#workingShift"><i class="talenta-kalender-9 fa-3x mb20"></i>Working Shift</a></li>
		        <li class="tab col l12"><a href="#overtime"><i class="talenta-jam-1 fa-3x mb20"></i>overtime</a></li>
		      </ul>
		    </div>

		    <!-- tab-content -->
		    <div class="col l10 white pad-l-n h-tabRow">
		    	<!-- Pattern 
			    <div id="pattern" class="col l12 pad-20 tab-content">
			    	<div class="row">
			    		<p class="titleB01">Pattern</p>
			    		<hr class="mt10 mb20">
			    		<div class="col l5 input-field">
			    			<input type="text" id="patternName">
			    			<label for="patternName">Pattern Name</label>
			    		</div>
			    		<div class="col l1">
			    			<a href="#!" class="btn btnB01 mt20">add</a>
			    		</div>
			    		<div class="col l12 mt40">
			    			<a href="#!" class="btn btnB01">add & save pattern</a>
			    		</div>
			    		<div class="col l12 mt40">
			    			<table class="bordered">
			    				<thead class="grey lighten-3 bold">
			    					<tr>
			    						<td>Pattern Name</td>
			    						<td>Created Date</td>
			    						<td>Action</td>
			    					</tr>
			    				</thead>
			    				<tbody>
			    					<tr>
			    						<td>Talenta Pattern</td>
			    						<td>2015-07-09 16:42:48</td>
			    						<td><a href="#!" class="bold red1-text">Detail</a> | <a href="#!" class="bold red1-text">Delete</a></td>
			    					</tr>
			    				</tbody>
			    			</table>
			    		</div>
			    	</div>
			    </div>
				-->

				<!-- schedule 
			    <div id="schedule" class="col l12 pad-20 tab-content">
			    	<div class="row">
			    		<p class="titleB01">Schedule</p>
			    		<hr class="mt10 mb20">
			    		<div class="col l8 input-field">
			    			<input type="text" id="schName">
			    			<label for="schName">Schedule Name</label>
			    		</div>
			    		<div class="col l8 input-field">
			    			<select id="schPattern">
			    				<option>--Select Pattern--</option>
			    			</select>
			    			<label for="schPattern">Pattern</label>
			    		</div>
			    		<div class="col l8 input-field">
			    			<input type="text" id="schDate" class="calendar">
			    			<label for="schDate">Effective Date</label>
			    		</div>
			    		<div class="col l8 input-field">
			    			<select id="schShift">
			    				<option>--Select Initial Shift--</option>
			    			</select>
			    			<label for="schShift">Initial Shift</label>
			    		</div>
			    		<div class="col l12 input-field">
			    			<input type="checkbox" id="overideNH" class="filled-in">
			    			<label for="overideNH">Overide National Holiday</label>
			    		</div>
			    		<div class="col l12 input-field">
			    			<input type="checkbox" id="overideCH" class="filled-in">
			    			<label for="overideCH">Overide Company Holiday</label>
			    		</div>
			    		<div class="col l12 input-field">
			    			<input type="checkbox" id="flexible" class="filled-in">
			    			<label for="flexible">Flexible
			    				<a class="tooltip2 tooltip2-right">
			    					<i class="fa fa-info-circle"></i>
			    					<span class="left-align f10 mb5">
										<p>Flexible means you can come anytime as long as //tooltiped </p>
									</span>
			    				</a>
			    			</label>
			    		</div>
			    		<div class="col l12 mt40 right-align">
							<a href="#!" class="btn btnB01">Save & add schedule</a>
			    		</div>
			    		<div class="col l12 mt40">
			    			<table class="bordered">
			    				<thead class="grey lighten-3 bold">
			    					<tr>
			    						<td>Name</td>
			    						<td>Pattern</td>
			    						<td>Initial Shift</td>
			    						<td>Flexible</td>
			    						<td>Effective Date</td>
			    						<td>Action</td>
			    					</tr>
			    				</thead>
			    				<tbody>
			    					<tr>
			    						<td>Test 123</td>
			    						<td>Talenta Pattern 2</td>
			    						<td>A</td>
			    						<td>Yes</td>
			    						<td>2015-09-30</td>
			    						<td>
			    							<a href="#!" class="bold red1-text" data-tooltip="Set as Default"><i class="fa fa-check"></i></a>&nbsp;
			    							<a href="#!" class="bold red1-text" data-tooltip="Detail"><i class="fa fa-list"></i></a>&nbsp;
			    							<a href="#!" class="bold red1-text" data-tooltip="Remove"><i class="fa fa-trash"></i></a>
			    						</td>
			    					</tr>
			    				</tbody>
			    			</table>
			    		</div>
			    	</div>
			    </div>
			    -->

			    <!-- attendance 
			    <div id="attendance" class="col l12 pad-20 tab-content">
			    	<div class="row">
			    		<p class="titleB01">Setting Attendance</p>
			    		<hr class="mt10 mb20">
		    			<div class="col l12">
			    			<a href="#modalNewAttendance" class="btn btnB01 modal-trigger">new</a>
			    		</div>
			    		<div class="col l12 mt30">
			    			<table>
			    				<thead class="grey lighten-3 bold">
			    					<tr>
			    						<td>Name Setting</td>
			    						<td>Action</td>
			    					</tr>
			    				</thead>
			    				<tbody>
			    					<tr>
			    						<td>Test 123</td>
			    						<td>
			    							<a href="#!" class="red1-text bold mr10" data-tooltip="Edit"><i class="fa fa-edit"></i></a>
			    							<a href="#!" class="red1-text bold" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
			    						</td>
			    					</tr>
			    				</tbody>
			    			</table>
			    		</div>
			    	</div>
			    </div>
				-->
				
				<!-- workingShift -->
				<div id="workingShift" class="col l12 pad-20 tab-content">
				  {!! Form::model($workingShift,array('url' => route('setting.workingshift') )) !!}
					<div class="row">
						<div class="col s12 mb30">
							<p class="lato-light grey-text text-darken-2 f23 mb10">Company Configuration</p>
							<p class="lato-black red1-text f18">Working Shift</p>
						</div>
						<div class="col s12 bBottom">
							<p class="lato-black">Working hours</p>
							<table>
								<tr>
									<td>
										Starts at
										<?= Form::text('start_hour',null,array('maxlength'=>2,'class'=>'w50 input1 ml5 mr5 center-align')) ?>
										<?= Form::text('start_minute',null,array('maxlength'=>2,'class'=>'w50 input1 mr5 center-align')) ?>
										and ends at
										<?= Form::text('end_hour',null,array('maxlength'=>2,'class'=>'w50 input1 mr5 ml10 center-align')) ?>
										<?= Form::text('end_minute',null,array('maxlength'=>2,'class'=>'w50 input1 mr5 mr5 center-align')) ?>
									</td>
								</tr>
							</table>
						</div>
						<div class="col l12">
							<p class="lato-black mt20">Working days</p>
						</div>
						@foreach (BaseService::getDay() as $key => $value)
						<div class="col s12 input-field mt5">
							<?=Form::checkbox('working_days[]',$key,$workingDayFlag[$key],['class'=>'filled-in','id'=>'wd_'.$key]) ?>
							<?=Form::label('wd_'.$key, $value)?>
						</div>
						@endforeach
					</div>
					<div class="row">
						<a href="#!" class="btn btnB01 submitButton">Save</a>
						<input class="text_success" type="hidden" value="Set Working Shift Successfull" >
					</div>
				{!! Form::close() !!}
				</div>


			    <!-- overtime -->
			    <div id="overtime" class="col l12 pad-20 tab-content">
			    	<div class="row">
			    		<div class="col s12 mb30">
							<p class="lato-light grey-text text-darken-2 f23 mb10">Company Configuration</p>
							<p class="lato-black red1-text f18">Overtime</p>
						</div>
						<div class="col s12">
							<p class="lato-black">Overtime Compensation</p>
						</div>
						<div class="col l2 wAuto mt0 input-field">
			    			<input type="radio" class="with-gap" id="defaultCompensation">
			    			<label for="defaultCompensation">Default</label>
			    		</div>
			    		<div class="col l2 mt0">
			    			<p class="mt10 grey lighten-3 pad-5 center-align displayInlineBlock">Salary / 173</p>
			    		</div>
			    		<div class="clearfix"></div>
			    		<div class="col s3 wAuto mt0 input-field">
			    			<input type="radio" class="with-gap" id="amountOvertime">
			    			<label for="amountOvertime">Set Amount</label>
			    		</div>
			    		<div class="col s4 mt0 input-field wAuto">
			    			<input type="text" id="perHour" class="input1 w100p mt10 money">
			    		</div>
			    		<div class="col s5">
			    			<p class="italic mt20">per hour</p>
			    		</div>
			    		<div class="clearfix"></div>
						<hr class="hr1 clearfix mt20 mb20">
			    		<div class="col s12">
							<p class="lato-black">Rounding Setting</p>
						</div>
						<div class="col s8">
							<table class="tableHover" id="overtimeRounding">
								<tr class="template">
									<td width="50">
										<input class="input1 w50">
									</td>
									<td>
										minutes
									</td>
									<td>
										-
									</td>
									<td>
										<input class="input1 w50">
									</td>
									<td>
										minutes
									</td>
									<td>
										=
									</td>
									<td>
										<input class="input1 w50">
									</td>
									<td>
										hour
									</td>
									<td width="100">
										<a href="#!" class="link1 red1-text deleteTableRow"><i class="fa fa-times mr5"></i>delete</a>
									</td>
								</tr>
							</table>
						</div>
						<div class="col s12 mt20">
							<a href="#!" class="btn btn02 addTableRow" data-target="overtimeRounding">Add new Rounding</a>
						</div>
						<!--
			    		<p class="titleB01">Overtime Setting</p>
			    		<hr class="mt10 mb20">
		    			<div class="col l8">
			    			<table class="no-pad">
			    				<tr>
			    					<td width="55">
			    						<input type="number">
			    					</td>
			    					<td>
			    						<span class="mr15">minutes</span> -
			    					</td>
									<td width="55">
										<input type="number">
									</td>
									<td>
			    						<span class="mr15">minutes</span> =
			    					</td>
			    					<td width="55">
										<input type="number">
									</td>
									<td>
			    						<p class="left">minutes</p> <a href="#!" class="red1-text bold ml10"><i class="fa fa-times"></i></a>
			    					</td>
			    				</tr>
			    				<tr>
			    					<td width="55">
			    						<input type="number">
			    					</td>
			    					<td>
			    						<span class="mr15">minutes</span> -
			    					</td>
									<td width="55">
										<input type="number">
									</td>
									<td>
			    						<span class="mr15">minutes</span> =
			    					</td>
			    					<td width="55">
										<input type="number">
									</td>
									<td>
			    						<p class="left">minutes</p> <a href="#!" class="red1-text bold ml10"><i class="fa fa-times"></i></a>
			    					</td>
			    				</tr>
			    				<tr>
			    					<td width="55">
			    						<input type="number">
			    					</td>
			    					<td>
			    						<span class="mr15">minutes</span> -
			    					</td>
									<td width="55">
										<input type="number">
									</td>
									<td>
			    						<span class="mr15">minutes</span> =
			    					</td>
			    					<td width="55">
										<input type="number">
									</td>
									<td>
			    						<p class="left">minutes</p> <a href="#!" class="red1-text bold ml10"><i class="fa fa-times"></i></a>
			    					</td>
			    				</tr>
			    				<tr>
			    					<td width="55">
			    						<input type="number">
			    					</td>
			    					<td>
			    						<span class="mr15">minutes</span> -
			    					</td>
									<td width="55">
										<input type="number">
									</td>
									<td>
			    						<span class="mr15">minutes</span> =
			    					</td>
			    					<td width="55">
										<input type="number">
									</td>
									<td>
			    						<p class="left">minutes</p> <a href="#!" class="red1-text bold ml10"><i class="fa fa-times"></i></a>
			    					</td>
			    				</tr>
			    			</table>
			    		</div>
			    		<div class="col l6 input-field">
			    			<input type="checkbox" class="filled-in" id="noRounding">
			    			<label for="noRounding">No Rounding</label>
			    		</div>
			    		-->
			    	</div>
			    </div>
		    </div>
		</div>
	</div>


	<!-- Modal New Attendance -->
	<div id="modalNewAttendance" class="modal modal-fixed-footer">
		<div class="modal-content">
		  <h4 class="titleB01">New Attendance</h4>
		  <hr class="mb20">
		  <div class="row">

		  	<!-- Kiri -->
		  	<div class="col l6">
		  		<div class="row mt0">
		  			<!-- Row 1 -->
				  	<div class="col mt0 l12 input-field">
				  		<input type="radio" class="with-gap" id="singleRow">
				  		<label for="singleRow">Single Row</label>
				  	</div>
				  	<div class="col mt0 l12 input-field">
				  		<input type="radio" class="with-gap" id="multipleRow">
				  		<label for="multipleRow">Multiple Row</label>
				  	</div>
				  	<div class="col mt0 l12 input-field">
				  		<input type="checkbox" class="filled-in" id="headerRow">
				  		<label for="headerRow">With header row</label>
				  	</div>

				  	<!-- Row 2 -->
				  	<div class="col l12 input-field">
				  		<input type="text" id="settingAttendanceName">
				  		<label for="settingAttendanceName">Setting Name</label>
				  	</div>

				  	<!-- Row 3 -->
				  	<div class="col l6 input-field">
				  		<select>
				  			<option>--Selet File Type--</option>
				  			<option>CSV</option>
				  			<option>DAT</option>
				  		</select>
				  		<label>File Type</label>
				  	</div>
				  	<div class="col l6 input-field">
				  		<select>
				  			<option>--Selet Delimiter--</option>
				  			<option>Comma (,)</option>
				  			<option>Dot (,)</option>
				  		</select>
				  		<label>File Type</label>
				  	</div>

				  	<!-- Row 4 -->
				  	<div class="col l6 input-field">
				  		<input type="text" id="barcode">
				  		<label for="barcode">Barcode</label>
				  	</div>
				  	<div class="col l6 input-field">
				  		<input type="text" id="barcodeLength">
				  		<label for="barcodeLength">Barcode Length</label>
				  	</div>

				  	<!-- Row 5 -->
				  	<div class="col l6 input-field">
				  		<input type="text" id="CheckIn">
				  		<label for="CheckIn">Check In</label>
				  	</div>
				  	<div class="col l6 input-field">
				  		<input type="text" id="CheckInLength">
				  		<label for="CheckInLength">Check In Length</label>
				  	</div>

				  	<!-- Row 6 -->
				  	<div class="col l6 input-field">
				  		<input type="text" id="CheckOut">
				  		<label for="CheckOut">Check Out</label>
				  	</div>
				  	<div class="col l6 input-field">
				  		<input type="text" id="CheckOutLength">
				  		<label for="CheckOutLength">Check Out Length</label>
				  	</div>

				</div>
		  	</div>

		  	<!-- Kanan -->
		  	<div class="col l6">
		  		<div class="row">
		  			<!-- Row 1 -->
				  	<div class="col l6 input-field">
				  		<input type="text" id="date">
				  		<label for="date">Date</label>
				  	</div>
				  	<div class="col l6 input-field">
				  		<input type="text" id="dateLength">
				  		<label for="dateLength">Date Length</label>
				  	</div>

				  	<!-- Row 2 -->
				  	<div class="col l6 input-field">
				  		<select>
				  			<option>--Selet Date Type--</option>
				  			<option>Y-M-D</option>
				  			<option>Y-M-D</option>
				  		</select>
				  		<label>Date Format</label>
				  	</div>
				  	<div class="col l6 input-field">
				  		<select>
				  			<option>--Selet Time Type--</option>
				  			<option>H:M:s (24)</option>
				  			<option>H:M:s (12)</option>
				  		</select>
				  		<label>Time FOrmat</label>
				  	</div>
		  		</div>
		  	</div>
		  </div>

		</div>
		<div class="modal-footer">
		  <a href="#!" class="modal-action modal-close btn btnB01">Close</a>
		  <a href="#!" class="modal-action modal-close btn btnB01 mr5">Save</a>
		</div>
	</div>
@endsection
