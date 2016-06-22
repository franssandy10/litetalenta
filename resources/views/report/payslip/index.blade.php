@extends('layouts.app')
@include('employee.reactEmployee')
@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
 @endsection

@section('customCss')
@endsection
@section('customjs')

@endsection

@section('content')
@include('layouts.headers.general')
	<div class="container mt30">
		<div class="row">
	      <div class="col l3 m5 s12 right">
	        <input type="text" class="search" placeholder="Search" id="searchLive">
	      </div>
	      <!-- <div class="col l2 right">
	        <select id="columnselect">
	          <option value="all">All Column</option>
	          <option value="0">Employee ID</option>
	          <option value="1">Employee Name</option>
	        </select>
	        <label for="columnSelect"></label>
	      </div> -->
	    </div>
		<div class="row">
			<div class="col l12 m12 s12">
				<table class="table">
					<thead class="grey lighten-3">
						<tr>
							<th width="100">Employee ID</th>
							<th>Employee Name</th>
							<th width="100">Action</th>
						</tr>
					</thead>
					<tbody>
            @foreach ($employee_list as $employee)
						<tr>
							<td>{{$employee->employee_id}}</td>
							<td>{{$employee->first_name." ".$employee->last_name}}</td>
							<td>
								<a data-tooltip="View" href="{{route('report.payslip.detail',['id'=>$employee->id,'month'=>$month,'year'=>$year])}}" class="red1-text bold mr10"><i class="fa fa-eye"></i></a>
								<a data-tooltip="Download" href="{{route('reportpayslippdf',['type'=>'download','id'=>$employee->id,'month'=>$month,'year'=>$year])}}" class="red1-text bold"><i class="fa fa-download"></i></a>
							</td>
						</tr>

            @endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
