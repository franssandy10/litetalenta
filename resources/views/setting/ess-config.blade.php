@extends('layouts.app')

@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
@endsection

@section('customCss')
	{!! Html::style('assets/css/style-setting.css')!!}
	{!! Html::style('assets/plugins/dataTable/datatables.min.css')!!}
@endsection

@section('customjs')
	{!! Html::script('assets/plugins/dataTable/datatables.min.js')!!}
@endsection

@section('content')
	@include('layouts.navbars.header-setting')

	<div class="container">
		<div class="row h-tabRow">
		    <div class="col l2 pad-r-n pad-l-n">
		      <ul class="tabs tab-horizontal">
		        <li class="tab col l12"><a href="#approval"><i class="talenta-centang-approval fa-3x mb20"></i>approval</a></li>
		        <li class="tab col l12"><a href="#delegation"><i class="talenta-delegasi-panah fa-3x mb20"></i>delegation</a></li>
		        <li class="tab col l12"><a href="#module"><i class="talenta-modul-1 fa-3x mb20"></i>module</a></li>
		      </ul>
		    </div>

		    <!-- tab-content -->
		    <div class="col l10 white pad-l-n h-tabRow">
		    	<!-- Approval -->
			    <div id="approval" class="col l12 pad-20 tab-content">
			    	<div class="row">
			    		<p class="titleB01">Approval Setting</p>
			    		<hr class="mt10 mb20">
			    		<div class="col l12">
			    			<table class="bordered">
			    				<thead class="grey lighten-3 bold">
			    					<tr>
			    						<td>Name Setting</td>
			    						<td>Action</td>
			    					</tr>
			    				</thead>
			    				<tbody>
			    					<tr>
			    						<td>Overtime Request</td>
			    						<td><a href="#!" class="btn btnB01">edit</a></td>
			    					</tr>
			    				</tbody>
			    			</table>
			    		</div>
			    	</div>
			    </div>

				<!-- delegation -->
			    <div id="delegation" class="col l12 pad-20 tab-content">
			    	<div class="row">
			    		<p class="titleB01">Delegation Setting</p>
			    		<hr class="mt10 mb20">

			    		<div class="col l12">
			    			<table class="bordered">
			    				<thead class="grey lighten-3 bold">
			    					<tr>
			    						<td>Start Date</td>
			    						<td>End Date</td>
			    						<td>From Name</td>
			    						<td>To Name</td>
			    						<td>Action</td>
			    					</tr>
			    				</thead>
			    				<tbody>
			    					<tr>
			    						<td>12 January 2015</td>
			    						<td>12 January 2015</td>
			    						<td>Rizki Andrianto</td>
			    						<td>Andreas Saputra</td>
			    						<td>Action</td>
			    					</tr>
			    				</tbody>
			    			</table>
			    		</div>
			    	</div>
			    </div>

			    <!-- module -->
			    <div id="module" class="col l12 pad-20 tab-content">
		    		<div class="row">
		    			<p class="titleB01">Module Setting</p>
		    			<hr class="mt10 mb20">
		    		</div>
			    	<div class="row">
			    		<div class="col l4 input-field">
			    			<select>
			    				<option>Show Active</option>
			    				<option>Show All</option>
			    			</select>
			    			<label>Address Book</label>
			    		</div>
			    		<div class="col l4 input-field">
			    			<select>
			    				<option>Show</option>
			    				<option>Hide</option>
			    			</select>
			    			<label>Show Salary in My Info</label>
			    		</div>
			    		<div class="col l12 mt30 right-align">
			    			<a href="#!" class="btn btnB01">save</a>
			    		</div>
			    	</div>
			    </div>
		    </div>
		</div>
	</div>
@endsection

