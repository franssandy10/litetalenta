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
		<div class="row">
			<div class="col l12 m12 s12">
				<table class="dataTable">
					<thead class="grey lighten-3 bold">
						<tr>
							<td>Code</td>
							<td>Name</td>
							<td>Duration</td>
							<td width="50" class="center-align">Include Day Off</td>
							<td width="50" class="center-align">Allow Half Day</td>
							<td width="50" class="center-align">Set Schedule (half day)</td>
							<td width="50" class="center-align">Set Default</td>
							<td width="50" class="center-align">Emerge at Join (Default Only)</td>
							<td width="50" class="center-align">Show</td>
							<td width="50" class="center-align">Max Request (in a row)</td>
							<td class="center-align" width="50">Allow Minus</td>
							<td>Max</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>CBA</td>
							<td>Cuti Baptis Anak</td>
							<td width="50" class="center-align">
								<input type="text">
							</td>
							<td class="center-align">NO</td>
							<td class="center-align">NO</td>
							<td class="center-align">
								<div class="col l12 m12 s12 input-field mtm15">
									<input type="checkbox" class="filled-in" id="1">
									<label for="1"></label>
								</div>
							</td>
							<td class="center-align">
								<div class="col l12 m12 s12 input-field mtm15">
									<input type="checkbox" class="filled-in" id="2">
									<label for="2"></label>
								</div>
							</td>
							<td class="center-align">
								<div class="col l12 m12 s12 input-field mtm15">
									<input type="checkbox" class="filled-in" id="3">
									<label for="3"></label>
								</div>
							</td>
							<td class="center-align">
								<div class="col l12 m12 s12 input-field mtm15">
									<input type="checkbox" class="filled-in" id="4">
									<label for="4"></label>
								</div>
							</td>
							<td class="center-align">
								<input type="text">
							</td>
							<td class="center-align">NO</td>
							<td class="center-align" width="50">
								<input type="text">
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
