@extends('layouts.app')

<?php
    $generalHeaderButton = 'Back to Time Off';
    $generalHeaderLink = 'http://facebook.com';
?>
@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
@endsection

@section('customCss')
    {!! Html::style('assets/plugins/dataTable/datatables.min.css')!!}
@endsection
@section('customjs')
    {!! Html::script('assets/plugins/dataTable/datatables.min.js')!!}
    {!! Html::script('assets/js/scriptDataTable.js')!!}
@endsection

@section('content')
	@include('layouts.headers.general')
	<div class="container mt30">
		<custom>
			<a href="#!" class="btn btnB01 mt10">export</a>
		</custom>
		<div class="row">
			<div class="col l12 m12 s12">
				<table class="dataTable">
					<thead class="grey lighten-3 bold">
						<tr>
							<td>Employee</td>
							<td>Balance</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Rizki Andrianto</td>
							<td>12</td>
							<td>
								<a href="#!" class="red1-text bold" data-tooltip="Got to this Employee's Timeoff Info"><i class="fa fa-user mr5"></i></a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
