@extends('layouts.app')
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
	      <div class="col l3 m12 s12 right">
	        <input type="text" class="search" placeholder="Search" id="searchLive">
	      </div>
	    </div>
		<div class="row">
			<div class="col l12 m12 s12">
				<table class="responsive-table table">
					<thead class="grey lighten-3 bold">
						<tr>
							<td width="50">
								<div class="input-field mtm10">
									<input type="checkbox" class="filled-in" id="checkboxAll">
									<label for="checkboxAll"></label>
								</div>
							</td>
							<td>No</td>
							<td>Employee ID</td>
							<td>Full Name</td>
							<td width="75">Balance</td>
							<td>Start Date</td>
							<td>End Date</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class="input-field mtm20">
									<input type="checkbox" class="filled-in" id="check1">
									<label for="check1"></label>
								</div>
							</td>
							<td>1</td>
							<td>TDI-001</td>
							<td>Rizki Andrianto</td>
							<td>35</td>
							<td>
								<div class="input-field">
									<input type="text" class="datepicker">
								</div>
							</td>
							<td>
								<div class="input-field">
									<input type="text" class="datepicker">
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="input-field mtm20">
									<input type="checkbox" class="filled-in" id="check2">
									<label for="check2"></label>
								</div>
							</td>
							<td>1</td>
							<td>TDI-001</td>
							<td>Hanif Abs</td>
							<td>35</td>
							<td>
								<div class="input-field">
									<input type="text" class="datepicker">
								</div>
							</td>
							<td>
								<div class="input-field">
									<input type="text" class="datepicker">
								</div>
							</td>
						</tr>						
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
