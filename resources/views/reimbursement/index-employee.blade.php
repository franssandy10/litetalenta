@extends('layouts.app')
@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
@endsection

@section('customCss')

@endsection


@section('content')

	<?php
		$generalHeaderButton = '<a href="#modalRequestReimbursement" class="modal-trigger grey-text lato-bold"><i class="talenta-tambah displayInlineBlock mr5 fa-2x"></i>Request Reimbursement</a>';
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

							@foreach($availableReimbursement as $data)
							@if($data->policy)
							<div class="col l3 m3 s6 mb20">
								<div class="white center-align valign-wrapper minHeight100">
									<div class="valign w100p">
										<p class="lato-black red1-text">{{$data->policy->name}}</p>
										<p class="f20 bold">{{ ReimbursementQuota::getMyBalancePerPolicy($data->policy->id,Sentinel::getUser()->userAccessConnection->employee_id_fk,true)}}</p>
									</div>
								</div>
							</div>
							@endif
							@endforeach
							<!-- <div class="col l3 m3 s6 mb20">
								<div class="white center-align valign-wrapper minHeight100">
									<div class="valign w100p">
										<p class="lato-black red1-text">Kesehatan</p>
										<p class="f20 bold">Rp 12,000</p>
									</div>
								</div>
							</div>
							<div class="col l3 m3 s6 mb20">
								<div class="white center-align valign-wrapper minHeight100">
									<div class="valign w100p">
										<p class="lato-black red1-text">Kacamata</p>
										<p class="f20 bold">Rp 12,000</p>
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
					<!-- Template -->
					<!-- <li class="collection-item avatar">
				      <span class="title lato-black red1-text">Policy Name</span>
				      <p class="f13">
				      	<strong class="bold">12 June 2016</strong><br>
				      	Rp 12,000<br>
				      	Reason
				      </p>
				      <a href="#!" class="secondary-content"><span class="new-badge green white-text pad-5 f9">Approved</span></a>
				    </li> -->
				    <!-- Template -->

					@foreach ($myReimbursementList as $myReimbursement)

					<li class="collection-item avatar">
				      <span class="title lato-black red1-text">{{$myReimbursement->policy->name}}</span>
				      <p class="f13">
				      	<strong class="bold">{{Carbon\Carbon::parse($myReimbursement->created_date)->format('d F Y')}}</strong><br>
				      	Rp {{number_format($myReimbursement->amount,0,'.',',')}} <br>
				      	{{ $myReimbursement->reason }}

				      	@if($myReimbursement['approvement'])
				      	<br/> {{ $myReimbursement['approvement']}}
				      	@endif
				      </p>
				      @if($myReimbursement->approved_flag==0)
				      	<a href="#!" class="secondary-content"><span class="new-badge grey white-text pad-5 f9">Pending</span></a>

				      @elseif($myReimbursement->approved_flag==1)
				      	<a href="#!" class="secondary-content"><span class="new-badge green white-text pad-5 f9">Approved</span></a>
				      @elseif($myReimbursement->approved_flag==2)

				      <a href="#!" class="secondary-content"><span class="new-badge bgRed1 white-text pad-5 f9">Rejected</span></a>
				      @endif
				    </li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
	@include('reimbursement/partials/detail-request-modal')
	@include('reimbursement/request-modal')
@endsection
@section('customjs')
	@yield('requestjs')
@endsection