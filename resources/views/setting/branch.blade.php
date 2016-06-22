@extends('layouts.app')

@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
@endsection

@section('customCss')
	{!! Html::style('assets/css/style-setting.css')!!}
@endsection

@section('content')
	@include('layouts.navbars.header-setting')

	<div class="container">
		<div class="row h-tabRow">
		    <div class="col l2 pad-r-n pad-l-n">
		      <ul class="tabs tab-horizontal">
		        <li class="tab col l12"><a href="#branch-list"><i class="fa fa-user fa-2x mb20"></i>Branch list</a></li>
		        <li class="tab col l12"><a href="#add-branch"><i class="talenta-tambah fa-2x mb20"></i>Add branch</a></li>
		      </ul>
		    </div>

		    <!-- tab-content -->
		    <div class="col l10 white pad-l-n h-tabRow">
		    	<!-- Branch List -->
			    <div id="branch-list" class="col l12 pad-20 tab-content">
			    	<div class="row">
			    		<p class="titleB01">Add New Branch</p>
			    		<hr class="mt10 mb20">
			    		<div class="col l12">
			    			<table class="bordered">
			    				<thead class="grey lighten-3 bold">
			    					<tr>
			    						<td>Branch Name</td>
			    						<td>Province</td>
			    						<td>City</td>
			    						<td>Action</td>
			    					</tr>
			    				</thead>
			    				<tbody>
			    					<tr>
			    						<td>Branch JKT</td>
			    						<td>Jakarta</td>
			    						<td>Jakarta</td>
			    						<td><a href="#!" class="bold red1-text">Edit</a> | <a href="#!" class="bold red1-text">Delete</a></td>
			    					</tr>
			    				</tbody>
			    			</table>
			    		</div>
			    	</div>
			    </div>

				<!-- Add Branch -->
			    <div id="add-branch" class="col l12 pad-20 tab-content">
			    	<div class="row">
			    		<p class="titleB01">Add New Branch</p>
			    		<hr class="mt10 mb20">
			    		<div class="col l12">
			    			
			    		</div>
			    	</div>
			    </div>
		    </div>
		</div>
	</div>
@endsection