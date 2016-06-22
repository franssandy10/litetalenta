@extends('layouts.app')
@include('employee.reactEmployee')
@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
 @endsection

@section('customCss')
	{!! Html::style('assets/css/style-setting.css')!!}
	{!! Html::style('assets/plugins/jquery.bxslider/jquery.bxslider.css')!!}
	{!! Html::style('assets/plugins/fullcalendar-2.4.0/fullcalendar.min.css')!!}
	<style type="text/css">
		.fc-unthemed thead {
			border:none;
		}

		.fc-ltr .fc-basic-view .fc-day-number {
			text-align: left;
		}

		.fc-day-grid-event .fc-content {
			background-image: url(assets/images/calendar_event_bg.png)
		}

		td.fc-widget-header, .fc-widget-header th {
			border:none;
		}

		.fc .fc-toolbar h2 {
			font-size: 1.5em;
		    color: #910111;
			font-family: 'lato-black';
		}
		
		.fc-toolbar button.fc-button.fc-state-active, 
		.fc-toolbar button.fc-button.fc-state-default{
		    background: #f5f5f5;
		    background-image: -webkit-gradient(linear,left top,left bottom,from(#f5f5f5),to(#f1f1f1));
		    background-image: -webkit-linear-gradient(top,#f5f5f5,#f1f1f1);
		    background-image: -moz-linear-gradient(top,#f5f5f5,#f1f1f1);
		    background-image: -ms-linear-gradient(top,#f5f5f5,#f1f1f1);
		    background-image: -o-linear-gradient(top,#f5f5f5,#f1f1f1);
		    background-image: linear-gradient(top,#f5f5f5,#f1f1f1);
		    border: 1px solid #dcdcdc;
		    border: 1px solid rgba(0,0,0,0.1);
		    border-radius: 2px;
		    color: #444;
		    cursor: pointer;
		    font-size: 11px;
		    font-weight: bold;
		    height: 27px;
		    line-height: 27px;
		    min-width: 54px;
		    outline: none;
		    padding: 0 8px;
		    text-align: center;
		    transition: all .218s;
		    -moz-border-radius: 2px;
		    -moz-transition: all .218s;
		    -moz-user-select: none;
		    -o-transition: all .218s;
		    -webkit-border-radius: 2px;
		    -webkit-transition: all .218s;
		    -webkit-user-select: none;
		    text-transform: capitalize;
		    font-family: 'lato-black';
		    z-index: 2;
		}

		.fc-toolbar .fc-icon {
			height: 27px;
			line-height: 27px;
			top: -2px;
		}

		.fc-toolbar button.fc-button.fc-state-default {
			background-image: none;
			background: #fff;
		}

		.fc-head .fc-row.fc-widget-header {
			border:none;
		}

		td.fc-widget-header {
			height: 40px;
		}

		.fc-toolbar {
			margin-bottom: 40px;
		}

		.fc-unthemed .fc-today {
			background: #eaeaea;
			font-weight:bold;
		}

		.sliderEvents li {
			width: 100% !important;
		}
		
		#sliderBox {
			position: relative;
		}

		#sliderBox.loading:after {
			-webkit-transition: all ease 0.5s;
			-o-transition: all ease 0.5s;
			transition: all ease 0.5s;
			background-image: url(assets/images/loading.gif);
			display: block;
			content: ' ';
			width: calc(100% - (0.75rem * 2));
			min-height: 500px;
			position: absolute;
			top: 0;
			background-position: center center;
			background-repeat: no-repeat;
			background-color: rgba(255, 255, 255, 0.65);
			z-index: 4;
			left: 0.75rem;
		}

		.bx-wrapper .bx-pager.bx-default-pager a {
			background: #EAEAEA
		}

		.bx-wrapper .bx-pager.bx-default-pager a.active,
		.bx-wrapper .bx-pager.bx-default-pager a:hover {
			background: #ADACAC;
		}

		.bx-wrapper .bx-pager {
			text-align: left;
		}

	</style>
@endsection
@section('customjs')
	{!! Html::script('assets/plugins/fullcalendar-2.4.0/moment.min.js')!!}
	{!! Html::script('assets/plugins/fullcalendar-2.4.0/fullcalendar.min.js')!!}
	{!! Html::script('assets/plugins/jquery.bxslider/jquery.bxslider.min.js')!!}
	{!! Html::script('assets/js/gcal.js')!!}
	<script type="text/javascript">
		$(document).ready(function() {
		    $('#calendar').fullCalendar({
		    	header: {
					left: 'today prev,next',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
		        eventLimit: 4, // for all non-agenda views
		        googleCalendarApiKey: 'AIzaSyBi1988g7yM0obvTcAv3XCG9pHwyFfx5eM',
		        eventSources: [
		        	{
		            	googleCalendarId: 'en.indonesian#holiday@group.v.calendar.google.com'
		        	},
		        	'{{route("calendar.events.timeoff")}}',
		        	'{{route("calendar.events.birthday")}}'
		        ],
		        eventRender: function(event, element, view){
		        	$('a.fc-event').attr('target', '_blank');
		        	var endDate, 
		        	end = '',
		        	startDate = moment(event.start).format('D MMMM YYYY');

		        	if ((moment(event.start).format('MM-DD') != moment(event.end).format('MM-DD')) && (event.end != null) && (event.url == undefined)) {
		        		endDate = moment(event.end).subtract(1, 'days').format('D MMMM YYYY');
		        		startDate = moment(event.start).format('D');
			        	end = ' - ' +	endDate;
		        	}

		        	var template = 	'<li>' +
			        					'<p class="lato-bold mb0">' + startDate + end + '</p>' +
							  			'<p class="lato-light mt5">' + event.title + '</p>' +
						  			'</li>';

	        		$('.sliderEvents').each(function(){
		        		if ($(this).children().length > 0) {
		        			var last = $(this).find('li:last-child')[0].outerHTML;
		        			if (last == template) {
		        				$(this).find('li:last-child').remove();
		        			}
	        			}
	        		});

	        		$('#allEventsCalendar').append(template);

	        		// TIME OFF COLORING
		        	if (event.type == 'T') {
		        		element.css({
		        						'background-color': 'rgb(37, 234, 0)', 
		        						'border-color': 'rgb(31, 195, 0)'
		        					});
		        		$('#timeOffCalendar').append(template);
		        	}

		        	// HOLIDAY COLORING
		        	else if (event.type == undefined || event.type == 'H') {
		        		element.css({
		        						'background-color': 'rgb(247, 66, 66)', 
		        						'border-color': 'rgb(255, 0, 0)'
		        					});
		        		$('.fc-day.fc-widget-content[data-date="' + moment(event.start).format('YYYY-MM-DD') + '"]').css('background-color' , 'rgba(255, 145, 145, 0.62)');
		        		$('#holidayCalendar').append(template);
		        	}

		        	// BIRTHDAY COLORING
		        	else if (event.type == 'B') {
		        		element.css({
		        						'background-color': 'rgb(81, 139, 255)', 
		        						'border-color': 'rgb(49, 117, 255)'
		        					});
		        		$('#birthdayCalendar').append(template);
		        	}
		        	/*setTimeout(function(){

		        	}, 200)*/
		        },
		        eventAfterAllRender: function(view){
		        	reloadSliderEvents();
		        	$('#select_view_events').change();
		        },
		        loading: function(isLoading){
		        	if (isLoading) {
			        	destroySliderEvents();
		        	}
		        }
		    })

		    jQuery('body').on( 'click', '.fc-event[href]', function(e){
			    e.preventDefault();
			    window.open( jQuery(this).attr('href'), '_blank' );
			});

			$('#select_view_events').change(function(){
				
				$('#sliderBox').addClass('loading')
				setTimeout(function(){
					reloadSliderEvents()
				},902)
			})

			/*sliderCalendar()*/
		});

		sliders =  new Array();
		configSlider = {
							controls: false,
						    pager: true,
						    infiniteLoop: false,
						    auto: false,
						    mode: 'vertical',
						    minSlides: 7,
						    maxSlides: 8,
						    slideMargin:15,
						    preloadImages: 'all',
						    adaptiveHeight: true,
						    responsive: true,
						}

		sliderObject = $('.sliderEvents').each(function(i, slider){
							sliders[i] = $(slider).bxSlider(configSlider);
						});

		function reloadSliderEvents(){
			$.each(sliders, function(i, slider) { 
	            slider.reloadSlider(configSlider);
	        });
	        $('#sliderBox').removeClass('loading')
		}

		function destroySliderEvents(){
			$.each(sliders, function(i, slider) { 
	            slider.destroySlider();
	        });
	        $('.sliderEvents').empty();
	        $('#sliderBox').addClass('loading')
		}

	</script>
@endsection

@section('content')
@include('layouts.headers.general')
	<div class="container mt30">
		<div class="row">
			<div class="col l8 s12 mb40" id="calendar">
			</div>
			<div class="col l4 s12">
				<div class="col s12 input-field mb20">
					<select class="tab-select" id="select_view_events">
						<option value="allEvents">All Events</option>
						<option value="timeOff">Time Off</option>
						<option value="birthday">Birthday</option>
						<option value="holiday">Holiday</option>
					</select>
					<label>View</label>
				</div>
				<div class="row">
					<div id="sliderBox" class="col s12">
						<div class="col s12 tab-select-container" id="allEvents">
							<ul class="sliderEvents" id="allEventsCalendar">
							</ul>
						</div>
						<div class="col s12 tab-select-container displayNone" id="timeOff">
							<ul class="sliderEvents" id="timeOffCalendar">
							</ul>
						</div>
						<div class="col s12 tab-select-container displayNone" id="birthday">
							<ul class="sliderEvents" id="birthdayCalendar">
							</ul>
						</div>
						<div class="col s12 tab-select-container displayNone" id="holiday">
							<ul class="sliderEvents" id="holidayCalendar">
							</ul>
						</div>	
						<div class="clearfix"></div>				
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
