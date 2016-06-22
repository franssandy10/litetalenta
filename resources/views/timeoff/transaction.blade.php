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
	      <div class="col l6 m6 s12">
	        <a href="#!" class="btn btnB01 mt10">Reset Period</a>
	      </div>
	      <div class="col l3 m6 s12 right">
	        <input type="text" class="search" placeholder="Search" id="searchLive">
	      </div>
	    </div>
		<div class="row">
			<div class="col l12 m12 s12">
				<table class="responsive-table">
					<thead class="grey lighten-3 bold">
						<tr>
							<td>ID</td>
							<td>Name</td>
							<td>Type</td>
							<td>Description</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>20160101</td>
							<td>Cuti Tahunan</td>
							<td>Assign</td>
							<td>Testing Fill</td>
							<td>
								<a href="#!" class="red1-text bold" data-tooltip="Edit Transaction"><i class="fa fa-edit mr5"></i></a>
								<a href="#!" class="red1-text bold" data-tooltip="Delete Transaction"><i class="fa fa-times mr5"></i></a>
							</td>
						</tr>
						<tr>
							<td>20160101</td>
							<td>Cuti Tahunan</td>
							<td>Assign</td>
							<td>Testing Fill</td>
							<td>
								<a href="#!" class="red1-text bold" data-tooltip="Edit Transaction"><i class="fa fa-edit mr5"></i></a>
								<a href="#!" class="red1-text bold" data-tooltip="Delete Transaction"><i class="fa fa-times mr5"></i></a>
							</td>
						</tr>
						<tr>
							<td>20160101</td>
							<td>Cuti Tahunan</td>
							<td>Assign</td>
							<td>Testing Fill</td>
							<td>
								<a href="#!" class="red1-text bold" data-tooltip="Edit Transaction"><i class="fa fa-edit mr5"></i></a>
								<a href="#!" class="red1-text bold" data-tooltip="Delete Transaction"><i class="fa fa-times mr5"></i></a>
							</td>
						</tr>
						<tr>
							<td>20160101</td>
							<td>Cuti Tahunan</td>
							<td>Assign</td>
							<td>Testing Fill</td>
							<td>
								<a href="#!" class="red1-text bold" data-tooltip="Edit Transaction"><i class="fa fa-edit mr5"></i></a>
								<a href="#!" class="red1-text bold" data-tooltip="Delete Transaction"><i class="fa fa-times mr5"></i></a>
							</td>
						</tr>
						<tr>
							<td>20160101</td>
							<td>Cuti Tahunan</td>
							<td>Assign</td>
							<td>Testing Fill</td>
							<td>
								<a href="#!" class="red1-text bold" data-tooltip="Edit Transaction"><i class="fa fa-edit mr5"></i></a>
								<a href="#!" class="red1-text bold" data-tooltip="Delete Transaction"><i class="fa fa-times mr5"></i></a>
							</td>
						</tr>
						<tr>
							<td>20160101</td>
							<td>Cuti Tahunan</td>
							<td>Assign</td>
							<td>Testing Fill</td>
							<td>
								<a href="#!" class="red1-text bold" data-tooltip="Edit Transaction"><i class="fa fa-edit mr5"></i></a>
								<a href="#!" class="red1-text bold" data-tooltip="Delete Transaction"><i class="fa fa-times mr5"></i></a>
							</td>
						</tr>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
