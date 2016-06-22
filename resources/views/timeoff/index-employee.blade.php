@extends('layouts.app')
@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
@endsection

@section('customCss')

@endsection
@section('customjs')
    <script type="text/javascript">
    	$(document).ready(function(){
    		$('.modal-trigger-request').click(function(){
				var url = $('#timeoffRequestDetailURL').val();
				var id = $(this).attr('id');
		        $.ajax({
		            type:"get",
		            dataType:'json',
		            url: url+'/'+id,
		            success: function (data) {
		            	$('.approvalButton').removeClass('hide'); //TODO: validasi approver apa bukan
		            	$('#modalDR-id').val(data.id);
		            	$('#modalDR-policy').html(data.policy.name);
		            	$('#modalDR-name').html(data.employee.first_name+' '+data.employee.last_name);
		            	$('#modalDR-start').html(data.start_date);
		            	$('#modalDR-end').html(data.end_date);
		            	$('#modalDR-amount').html(data.amount);
		            	$('#modalDR-reason').html(data.reason);
		            	// validasi apakah user == approver
		            	if(data.approver.isApprover == 1){
		            		$('.approvalButton').show();
		            	} else {
		            		$('.approvalButton').hide();
		            	}
		            	var status = 'Waiting approval from <br><ul>';

		            	//loop for each approver
		            	data.approver.list.forEach(function(item,index){
		            		status += '<li>' + item + '</li>';
		            	});
		            	status += '</ul>';
		            	$('#modalDR-status').html(status);
		            	$('#modalDetailRequest').openModal();
		            },
		            error: function(data){
		                console.log('Error :', data);
		            }
		        });
		    })

			$('.modal-trigger-history').click(function(){
				var url = $('#timeoffHistoryDetailURL').val();
				var id = $(this).attr('id');
		        $.ajax({
		            type:"get",
		            dataType:'json',
		            url: url+'/'+id,
		            success: function (data) {
		            	$('.approvalButton').addClass('hide');
		            	$('#modalDH-id').val(data.id);
		            	$('#modalDH-policy').html(data.policy.name);
		            	$('#modalDH-name').html(data.employee.first_name+' '+data.employee.last_name);
		            	$('#modalDH-date').html(data.date);
		            	$('#modalDH-amount').html(data.days_amount);
			            var status = 'Approved by '+data.approverName+' on '+data.created_date;
		            	$('#modalDH-status').html(status);
		            	$('#modalDetailHistory').openModal();
		            },
		            error: function(data){
		                console.log('Error :', data);
		            }
		        });
		    });

    	})
    </script>
@endsection

@section('content')

	<?php
		$generalHeaderButton = '<a href="#modalRequestTimeOff" class="modal-trigger grey-text lato-bold"><i class="talenta-tambah displayInlineBlock mr5 fa-2x"></i>Request Time Off</a>';
	?>
	@include('layouts.headers.general')

	<div class="container mt20">
			<div class="col s12 grey lighten-2">
				<div class="row valign-wrapper boxA01">
					<div class="col l2 valign center-align s12 pad-10">
						<p class="lato-black f13">YOUR BALANCE</p>
					</div>
					<div class="col l10 s12 pad-t-20 pad-b-none">
						<div class="mb0">

							@foreach($availableTimeOff as $data)
							@if($data->policy)
							<div class="col l3 m3 s6 mb20">
								<div class="white center-align valign-wrapper minHeight100">
									<div class="valign w100p">
										@if($data->policy->unlimited_flag)
											<p><span class="f30 grey-text text-lighten-1">Unlimited</span></p>
										@else
											<?php
												$balance = TimeOffQuota::getMyBalancePerPolicy(Sentinel::getUser()->userAccessConnection->employee_id_fk, $data->policy->id);
											?>
											<p><span class="f30 grey-text text-lighten-1">{{ $balance }}</span> <span class="lato-boldItalic grey-text text-lighten-1"> {{ $balance <= 1 ? 'day' : 'days' }}</span></p>
										@endif
										<p class="lato-black f12 ls1 grey-text text-uppercase truncate">{{$data->policy->name}} </p>
									</div>
								</div>
							</div>
							@endif
							@endforeach
							<!-- <div class="col l3 m3 s6 mb20">
								<div class="white center-align valign-wrapper minHeight100">
									<div class="valign w100p">
										<p><span class="f30 grey-text text-lighten-1">12</span> <span class="lato-boldItalic grey-text text-lighten-1">days</span></p>
										<p class="lato-black f12 ls1 grey-text text-uppercase truncate">YEARLY LEAVE</p>
									</div>
								</div>
							</div>
							<div class="col l3 m3 s6 mb20">
								<div class="white center-align valign-wrapper minHeight100">
									<div class="valign w100p">
										<p><span class="f30 grey-text text-lighten-1">12</span> <span class="lato-boldItalic grey-text text-lighten-1">days</span></p>
										<p class="lato-black f12 ls1 grey-text text-uppercase truncate">YEARLY LEAVE</p>
									</div>
								</div>
							</div> -->
						</div>
					</div>
				</div>
			</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col s12">
				<ul class="collection collection2">
				    @foreach($myTimeOffList as $myTimeOff)
 			<li class="collection-item avatar">
				      <span class="title lato-black red1-text">{{$myTimeOff->policy['name']}}</span>
				      <p>
				      	<strong class="bold">{{$myTimeOff->start_date == $myTimeOff->end_date ? $myTimeOff->end_date : $myTimeOff->start_date.' - '.$myTimeOff->end_date}}</strong><br>
				      	{{ $myTimeOff->amount }}<br>
				      	{{ $myTimeOff->reason }}
				      	@if(($myTimeOff->approved_flag==1 || $myTimeOff->approved_flag==2) && strlen(trim($myTimeOff->approvement_reason)) != 0)
				      	<br/>{{ $myTimeOff->approvement_reason }}
 				      	@endif
				      </p>
				      @if($myTimeOff->approved_flag==0)
				      	<a href="#!" class="secondary-content"><span class="new-badge grey white-text f9 pad-5">Pending</span></a>
				      @elseif($myTimeOff->approved_flag==1)
				      	<a hrf="#!" class="secondary-content"><span class="new-badge green white-text pad-5 f9">Approved</span></a>
				      @elseif($myTimeOff->approved_flag==2)
				      	<a href="#!" class="secondary-content"><span class="new-badge bgRed1 white-text f9 pad-5">Rejected</span></a>
				      @endif
				      <!-- kalo ditolak clas grey diganti jd bgRed1 -->
				    </li>

				    @endforeach
				</ul>
			</div>
		</div>
	</div>



	<!-- Modal Detail Request -->
	<div id="modalDetailRequest" class="modal modal-fixed-footer modal1">
		<div class="modal-content">
			<a href="#!" class="modal-action modal-close grey-text closeModal"><i class="fa fa-times"></i></a>
			<div class="row">
			  <p class="titleB01">Time Off Details</p>
			  <p id="modalDR-policy" class="f18 grey-text text-darken-3 lato-bold">Cuti Hamil</p>
			  <input type='hidden' id='modalDR-id' value=''>
			</div>
			<div class="row">
				<div class="bBottom pad-b-20">
					<div class="clearfix mb5">
						<p class="col l4 pad-l-n">Requested by</p>
						<p id="modalDR-name" class="col l8 bold">Cheryl Cyrilla</p>
					</div>

					<div class="clearfix mb5">
						<p class="col l4 pad-l-n">Start Date</p>
						<p id="modalDR-start" class="col l8 bold">15 November 2015 (Half Day)</p>
					</div>

					<div class="clearfix mb5 ">
						<p class="col l4 pad-l-n">End Date</p>
						<p id="modalDR-end" class="col l8 bold">20 November 2012 (Full Day)</p>
					</div>

					<div class="clearfix mb5">
						<p class="col l4 pad-l-n">Total Days</p>
						<p id="modalDR-amount" class="col l8 bold">6,5 days</p>
					</div>
					<div class="clearfix mb5">
						<p class="col l4 pad-l-n">Description</p>
						<p id="modalDR-reason" class="col l8 bold">Hamil 8 bulan</p>
					</div>
				</div>

				<div class="bBottom clearfix pad-b-20 pad-t-20">
					<p class="col l4 pad-l-n">Status</p>
					<div class="col l8 bold">
						<p id="modalDR-status" class="col l12 mb15 pad-l-n">Waiting</p>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer center-align">
		  	<a href="#!" class="approvalButton floatNone btn btnB01 mr5">Approve</a>
			<a href="#!" class="approvalButton floatNone btn btnB01">Reject</a>
		</div>
	</div>



	@include('timeoff/request-modal')
	@include('reimbursement/partials/delete-policy-modal')
@endsection
