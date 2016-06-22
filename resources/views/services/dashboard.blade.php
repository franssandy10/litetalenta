@extends('layouts.app')

@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
@endsection

@section('customCss')
{!! Html::style('assets/plugins/jquery.bxslider/jquery.bxslider.css')!!}
{!! Html::style('assets/plugins/fullcalendar-2.4.0/fullcalendar.min.css')!!}
<style type="text/css">
	.bx-wrapper .bx-viewport {
		background-color: transparent;
		border:none;
		box-shadow: none;
	}

	.bxslider li {
		height: 55px;
    	width: 100% !important;
	}

	.bx-wrapper {
		margin: 0 auto;
	}

	.bx-wrapper .bx-pager {
		overflow-x: auto;
    	white-space: nowrap;
	}

	.fc-toolbar {
		margin-bottom: 0px;
		margin-top: 20px;
	}

	.fc-toolbar h2 {
		font-size: 16px;
		float: left;
		height: 2em;
	    line-height: 2em;
	}

	.fc-button {
		border: none;
		background: transparent;
		outline: none;
		-webkit-box-shadow: none;
		box-shadow: none;
	}

	.fc-prev-button {
		float: left;
	}

	.fc-next-button {
		float: right;
	}

	.fc button .fc-icon {
		font-size: 10px;
	}

	.fc .fc-toolbar>*>:first-child,
	.fc .fc-toolbar>*>* {
		z-index: 1;
	    font-size: 13px;
	    font-family: 'lato-bold';
	    border: none;
	    outline: none;
	    background: none;
	    box-shadow: none;
	}

	.fc-view-container *, .fc-view-container :after, .fc-view-container :before,
	.fc td, .fc th {
		border: none;
	}

	.fc-ltr .fc-basic-view .fc-day-number {
	    text-align: center;
	    padding: 0;
	    cursor: pointer;
	}

	.fc td.fc-today {
		border:none;
		border-radius: 100%;
		color: #fff;
		background-color: transparent !important;
	}

	.fc-content-skeleton td.fc-today:after {
		content: ' ';
	    border-radius: 50%;
	    width: 25px;
	    height: 25px;
	    display: block;
	    position: absolute;
	    background-color: #aeaeae;
	    top: 7px;
	    left: 0;
	    right: 0;
	    bottom: 0;
	    background-repeat: no-repeat;
	    z-index: -1;
	    margin: 0 auto;
	}
	    margin: 0 auto;
	}

	.fc-month-view .fc-content-skeleton tbody {
		display: none;
	}

	.fc-basic-view .fc-body .fc-row {
		min-height: 0;
		height: 40px !important;
	}

	.fc .fc-row {
	    border-style: solid;
	    border-width: 0;
	    height: 40px;
	}

	.fc-row .fc-bgevent-skeleton td, .fc-row .fc-highlight-skeleton td {
		padding: 20px;
	}

	.fc-bgevent {
		background-color: transparent !important;
	}

	.fc-day-grid-event .fc-content {
		padding: 5px 10px;
	}

	.fc-toolbar .fc-right {
		margin-right: 3%;
	}

	.fc-toolbar .fc-left {
		margin-left: 3%;
	}

	.fc-view-container.basicDay {
		min-height: 401px;
	    overflow: hidden;
	    overflow-y: scroll;
	}

	.fc-row.fc-widget-header {
		border: none !important;
	}

	.fc-scroller {
	    overflow-y: visible;
	    overflow-x: visible;
	}

	.fc td.fc-today {
		position: relative;
	}

	.fc-day-number {
		vertical-align: middle !important;
		height: 40px;
	}

	.tabs .indicator{
		background-color: rgb(145, 1, 17);
		top:0;
	}

	.tabs .tab a {
		color: rgb(148, 148, 148);
		background-color: rgb(222, 227, 225);
		border: 1px solid rgba(40,44,42,0.1);
		border-bottom: none;
		font-family: 'lato-black';
		font-size: 12px;
	}

	.tabs .tab a i {
		margin-right: 8px;
	}

	.tabs .tab a:hover {
		color: rgb(145, 1, 17);
		background-color: #fff;
	}

	.tabs .tab a.active {
		background-color: #fff;
	}

	.tab-content {
		border: 1px solid rgba(40,44,42,0.1);
		height: 100%;
		width: 100%;
		border-top: none;
	}

	.tabs {
		overflow-x: hidden
	}


</style>
@endsection

@section('content')
<div class="container">
	<div class="row pad-t-25">
		<div class="col l9 s12">
			<div class="col l2 m12 s12 center-align">
				<img src="{{Sentinel::getUser()->userAccessConnection->getAvatar()}}" width="75" class="circle">
			</div>
			<div class="col l9 m12 s12">
				<p class="titleB01 f25 lato-black mb0 truncate mt10 center-align-down center-align-med">{{ $detail_user_access['full_name'] }}</p>
				<p class="lato-bold f16 grey-text mt0 truncate center-align-down center-align-med">{{ $detail_user_access['name_access'] }}</p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col l8 s12">
			<div class="hide-on-med-and-down mb40">
				<h1 class="titleB01">Welcome, {{ $detail_user_access['full_name'] }}.</h1>
				<p class="paragraphB01 lineHeight14">Talenta empowers you to store all informations regarding your employee in one place. You can also control all HR processes such as Time Off Requests, Overtime Requests, and processing Payroll, all under one place.</p>
			</div>
			<p class="titleB02 center-align-med center-align-down mt30 mb20">Shortcut</p>

			{{--@if ((new Sentinel::getUser()->getDetailUserAccess)['name_access'] == 'Employee')--}}
			@if (Sentinel::getUser()->getRoles()[0]->name == 'Super Admin')
		    	<a class="col l3 s4 dashboard-shortcut mb40" href="{{ URL::route('employeecreate') }}">
		            <!-- <img class="dashboard-imgShortcut" src="assets/new-talenta/images/dashboard-imgShortcut-addEmployee.png"> -->
		            <p><i class="talenta-orang-2 fa-5x"></i></p>
		            Add<br>Employee
		        </a>
		        <a class="col l3 s4 dashboard-shortcut mb40" href="#!">
		            <!-- <img class="dashboard-imgShortcut" src="assets/new-talenta/images/dashboard-imgShortcut-addEmployee.png"> -->
		            <p><i class="talenta-kalkulator-1 fa-5x"></i></p>
		            Process<br>Payroll
		        </a>
		    @endif

			@if (Sentinel::getUser()->userAccessConnection->employee_id_fk != null)
		        <a class="col l3 s4 dashboard-shortcut mb40 modal-trigger" href="#modalRequestReimbursement">
		            <!-- <img class="dashboard-imgShortcut" src="assets/new-talenta/images/dashboard-imgShortcut-addEmployee.png"> -->
		            <p><i class="talenta-reimbursement fa-5x"></i></p>
		            Request<br>Reimbursement
		        </a>
		        <a class="col l3 s4 dashboard-shortcut mb40 modal-trigger" href="#modalRequestTimeOff">
		            <!-- <img class="dashboard-imgShortcut" src="assets/new-talenta/images/dashboard-imgShortcut-addEmployee.png"> -->
		            <p><i class="talenta-kalender-8 fa-5x"></i></p>
		            Request<br>Time Off
		        </a>
		    @endif
	        
	        <!-- Task & Announcement Tabs -->
	        <?php if (false) { ?>
			<div class="col l12 m12 s12">
		    	<div class="row">
					<ul class="tabs">
						<li class="tab col s4 m4 l4"><a class="active" href="#test1"><i class="fa fa-pencil mr5"></i><span class="hide-on-small-only">Task</span></a></li>
						<li class="tab col s4 m4 l4"><a href="#test2"><i class="fa fa-bullhorn mr5"></i><span class="hide-on-small-only">Announcement</span></a></li>
					</ul>
				    
				    <!-- Tab 1 -->
				    <div id="test1" class="col s12 pad-l-n pad-r-n white h420">
				    	<div class="tab-content valign-wrapper">
					    	<div class="valign w100p center-align">
					    		<a class="lato-light f30 grey-text bold modal-trigger" href="#modalAddTask"><i class="fa fa-plus-circle mr15 cursorPointer"></i> Add New Task</a>
					    	</div>
				    	</div>
				    </div>

				    <!-- Tab 2 -->
				    <div id="test2" class="col s12 pad-l-n pad-r-n white h420">
				    	<div class="tab-content valign-wrapper">
					    	<div class="valign w100p center-align">
					    		<a class="lato-light f30 grey-text bold modal-trigger" href="#modalAddAnnouncement"><i class="fa fa-plus-circle mr15 cursorPointer"></i> Add New Announcement</a>
					    	</div>
				    	</div>
				    </div>
				</div>
		    </div>
		    <?php } ?>
		    <!-- Tabs -->
	    </div>
	    <div class="col l4 m12 s12">
	    	<div class="bgRed4 h320 relative valign-wrapper mt5">
				<div class="col l12 s12 m12 center-align-med center-align-down">
					<p class="white-text lato-black ls2 f11 text-uppercase absolute top0 center-align w100p mt10">who's on leave</p>
					@if(count($whos_on_leave)==0)
					<div class="white-text center-align">
						<p class="lato-bold f18 mb0">Full team at work this week!</p>
						<p class="lato-light f14 mt0">All your coworkers are in.</p>
					</div>
					@else
					<ul class="bxslider mt0 mb0 ">
					@foreach ($whos_on_leave as $timeoff)
					  <li>
					  	<div class="w50 left mr10 time-off-image">
					  		<img src="{{$timeoff['avatar']}}" class="circle" width="50">
					  	</div>
					  	<div class="left" style="width:calc(100% - 60px)">
					  		<p class="mt5 mb0 white-text bold truncate">{{$timeoff['name']}}</p>
					  		<p class="mt0 white-text mb0 lato-light">{{$timeoff['start']}} - {{$timeoff['policy']}}</p>
					  	</div>
					  	<div class="clearfix"></div>
					  </li>
					@endforeach
					  <!-- <li>
					  	<div class="w50 left mr10 time-off-image">
					  		<img src="uploads/avatar/blank.jpg" class="circle" width="50">
					  	</div>
					  	<div class="left" style="width:calc(100% - 60px)">
					  		<p class="mt5 mb0 white-text bold truncate">2. Rizki Andrianto asdasdas asdasdsad</p>
					  		<p class="mt0 white-text mb0 lato-light">Cuti Menikah</p>
					  	</div>
					  	<div class="clearfix"></div>
					  </li>
					  <li>
					  	<div class="w50 left mr10 time-off-image">
					  		<img src="uploads/avatar/blank.jpg" class="circle" width="50">
					  	</div>
					  	<div class="left" style="width:calc(100% - 60px)">
					  		<p class="mt5 mb0 white-text bold truncate">3 Rizki Andrianto asdasdas asdasdsad</p>
					  		<p class="mt0 white-text mb0 lato-light">Cuti Menikah</p>
					  	</div>
					  	<div class="clearfix"></div>
					  </li>
					  <li>
					  	<div class="w50 left mr10 time-off-image">
					  		<img src="uploads/avatar/blank.jpg" class="circle" width="50">
					  	</div>
					  	<div class="left" style="width:calc(100% - 60px)">
					  		<p class="mt5 mb0 white-text bold truncate">4 Rizki Andrianto asdasdas asdasdsad</p>
					  		<p class="mt0 white-text mb0 lato-light">Cuti Menikah</p>
					  	</div>
					  	<div class="clearfix"></div>
					  </li>
					  <li>
					  	<div class="w50 left mr10 time-off-image">
					  		<img src="uploads/avatar/blank.jpg" class="circle" width="50">
					  	</div>
					  	<div class="left" style="width:calc(100% - 60px)">
					  		<p class="mt5 mb0 white-text bold truncate">5 Rizki Andrianto asdasdas asdasdsad</p>
					  		<p class="mt0 white-text mb0 lato-light">Cuti Menikah</p>
					  	</div>
					  	<div class="clearfix"></div>
					  </li>
					  <li>
					  	<div class="w50 left mr10 time-off-image">
					  		<img src="uploads/avatar/blank.jpg" class="circle" width="50">
					  	</div>
					  	<div class="left" style="width:calc(100% - 60px)">
					  		<p class="mt5 mb0 white-text bold truncate">6 Rizki Andrianto asdasdas asdasdsad</p>
					  		<p class="mt0 white-text mb0 lato-light">Cuti Menikah</p>
					  	</div>
					  	<div class="clearfix"></div>
					  </li> -->
					</ul>
					@endif
				</div>
				<div class="dashboardOnLeave">
					<a href="{{route('calendar.index')}}" class="white-text"><i class="fa fa-chevron-circle-down mr5"></i>View Calendar</a>
				</div>
	    	</div>

		</div>
	    <div class="col l4 m12 s12" style="min-height: 350px;">
	    	<div class="calendar-dashboard">
	    	</div>
	    </div>

	    <?php if (false) { ?>
	    <!-- What's On -->
		<div class="col l4 m12 s12 mt40">
	    	<p class="text-uppercase ls2 f12 lato-black grey1-text mb10">what's on in september</p>
	    	<div class="">
	    		<div class="bBottom mb5">
	    			<p class="f12 mt0 mb0 bold grey1-text">02 September 2015</p>
	    			<p class="titleB01 f18 mt0 mb15">Alexander Novendo's Birthday</p>
	    		</div>
	    		<div class="bBottom mb5">
	    			<p class="f12 mt0 mb0 bold grey1-text">02 September 2015</p>
	    			<p class="titleB01 f18 mt0 mb15">Alexander Novendo's Birthday</p>
	    		</div>
	    	</div>
	    	<a class="lato-light f25 grey-text bold mt15 modal-trigger" href="#modalAddEvent"><i class="fa fa-plus-circle mr15 cursorPointer"></i> Add Event</a>
	    </div>
		<!-- What's On -->
		<?php } ?>
	</div>
</div>

<!-- Modal Add Task -->
<div id="modalAddTask" class="modal modal-fixed-footer">
	<div class="modal-content">
	  <h4 class="titleB01">Add New Task</h4>
	  <div class="row">
	  	<div class="col l12 s12 m12 input-field">
	  		<input type="text" id="titleTask">
	  		<label for="titleTask">Title</label>
	  	</div>
	  	<div class="col l6 m6 s12 input-field">
	  		<select class="assignTo">
	  			<option>Freddy</option>
	  		</select>
	  		<label>Assign To</label>
	  	</div>
	  	<div class="col l6 s12 m6 input-field">
	  		<input type="text" id="deadline" class="datepicker">
	  		<label for="deadline">Deadline</label>
	  	</div>
	  	<div class="col l12 s12 m12 input-field">
	  		<textarea class="materialize-textarea" id="description"></textarea>
	  		<label for="description">Description</label>
	  	</div>
	  	<div class="col l12 s12 input-field">
	  		<input type="checkbox" id="sendToEmail" class="filled-in">
	  		<label for="sendToEmail">Send to Email</label>
	  	</div>
	  </div>
	</div>
	<div class="modal-footer">
	  <a href="#!" class="modal-action modal-close btn btnB01">Close</a>
	  <a href="#!" class="modal-action modal-close btn btnB01 mr5">Save Changes</a>
	</div>
</div>

<!-- Modal Add Announcement -->
<div id="modalAddAnnouncement" class="modal modal-fixed-footer">
	<div class="modal-content">
	  <h4 class="titleB01">Add New Announcement</h4>
	  <div class="row">
	  	<div class="col l12 s12 m12 input-field">
	  		<input type="text" id="subjectAnnouncement">
	  		<label for="subjectAnnouncement">Subject</label>
	  	</div>
	  	<div class="col l12 m12 s12 input-field">
	  		<textarea id="editor"></textarea>
	  	</div>
	  </div>
	</div>
	<div class="modal-footer">
	  <a href="#!" class=" modal-action modal-close btn btnB01">Close</a>
	  <a href="#!" class=" modal-action modal-close btn btnB01 mr5">Save Changes</a>
	</div>
</div>

<!-- Modal Add Event -->
<div id="modalAddEvent" class="modal modal-fixed-footer">
	<div class="modal-content">
	  <h4 class="titleB01">Add New Event</h4>
	  	<div class="row">
		  	<div class="col l12 s12 m12 input-field">
		  		<input type="text" id="eventName">
		  		<label for="eventName">Event Name</label>
		  	</div>
		  	<div class="col l6 s12 m6 input-field">
		  		<input type="text" id="eventDate" class="datepicker">
		  		<label for="eventDate">Date</label>
		  	</div>
		  	<div class="col l1 s3 m6 input-field">
		  		<input type="text" id="days">
		  		<label for="days">Days</label>
		  	</div>
		  	<div class="col l5 s9 m6 input-field">
		  		<input type="checkbox" id="companyHoliday" class="filled-in">
		  		<label for="companyHoliday">company holiday</label>
		  	</div>
	  	</div>


	  	<div class="row mb0">
		  	<!-- From -->
	  		<div class="col l6 m12 s12 pad-l-n pad-r-n">
	  			<p class="col l12 m12 s12 mt0 mb0">From</p>
	  			<div class="row">
					<div class="col l4 s4 m4 input-field">
						<select>
							<option>00</option>
						</select>
					</div>
					<div class="col l4 s4 m4 input-field">
						<select>
							<option>00</option>
						</select>
					</div>
				  	<div class="col l4 m4 s4 input-field">
				  		<div class="switcher mt15">
				          <label>
				            <input name="typeStartTime" value="PM" type="checkbox">
				            <span class="am">AM</span>
				            <span class="pm">PM</span>
				          </label>
				        </div>
				  	</div>
	  			</div>
	  		</div>

	  		<!-- To -->
	  		<div class="col l6 m12 s12 pad-l-n pad-r-n">
	  			<p class="col l12 m12 s12 mt0 mb0">To</p>
	  			<div class="row">
					<div class="col l4 s4 m4 input-field">
						<select>
							<option>00</option>
						</select>
					</div>
					<div class="col l4 s4 m4 input-field">
						<select>
							<option>00</option>
						</select>
					</div>
				  	<div class="col l4 m4 s4 input-field">
				  		<div class="switcher mt15">
				          <label>
				            <input name="typeStartTime" value="PM" type="checkbox">
				            <span class="am">AM</span>
				            <span class="pm">PM</span>
				          </label>
				        </div>
				  	</div>
	  			</div>
	  		</div>
	  	</div><!-- Row -->
	  	<div class="row">
	  		<div class="col l12 m12 s12">
	  			<input type="radio" class="with-gap" id="everyone">
	  			<label for="everyone">Everyone can view this event</label>
	  		</div>
	  		<div class="col l12 m12 s12">
	  			<input type="radio" class="with-gap" id="onlyshow">
	  			<label for="onlyshow">Only show to selected people</label>
	  		</div>
	  	</div>

	  	<div class="row">
	  		<div class="col l12 m12 s12 input-field">
	  			<textarea class="materialize-textarea"></textarea>
	  			<label>Note</label>
	  		</div>
	  	</div>

	</div>
	<div class="modal-footer">
	  <a href="#!" class=" modal-action modal-close btn btnB01">Close</a>
	  <a href="#!" class=" modal-action modal-close btn btnB01 mr5">Save Changes</a>
	</div>
</div>
@include('timeoff/request-modal')
@include('reimbursement/request-modal')
@endsection
@section('customjs')

{!! Html::script('assets/plugins/fullcalendar-2.4.0/moment.min.js')!!}
{!! Html::script('assets/plugins/jquery.bxslider/jquery.bxslider.min.js')!!}
{!! Html::script('assets/plugins/fullcalendar-2.4.0/fullcalendar.min.js')!!}
{!! Html::script('assets/plugins/editor/tinymce.min.js')!!}
@yield('requestjs')
<script type="text/javascript">
	$(window).load(function(){
		tinymce.init({
		  selector: 'textarea#editor',
		  height: 250,
		  plugins: [
		    'advlist autolink lists link image charmap print preview anchor',
		    'searchreplace visualblocks code fullscreen',
		    'insertdatetime media table contextmenu paste code'
		  ],
		  toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
		  content_css: [
		    '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
		    '//www.tinymce.com/css/codepen.min.css'
		  ]
		});

		$('.bxslider').bxSlider({
		  	controls: false,
		  	mode:'vertical',
		  	infiniteLoop: false,
		  	adaptiveHeight: true,
		  	minSlides: 3
		});

		$('.calendar-dashboard').fullCalendar({
		    // put your options and callbacks here
		    header : {
			    left:   '',
			    center: 'prev,title,next',
			    right:  ''
			},
			events: [
				        {
				            title  : '1',
				            start  : '2015-11-27'
				        },
				        {
				            title  : '2',
				            start  : '2015-11-19',
				            end    : '2015-11-20'
				        },
				        {
				            title  : '3',
				            start  : '2015-11-19T12:30:00',
				            allDay : false // will make the time show
				        }
				    ]
	    })

	});
</script>
@endsection
