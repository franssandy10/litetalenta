@extends('layouts.app')
@include('employee.reactEmployee')
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

    <script type="text/javascript">
	    $(document).ready(function(){
	    	$('.custom-toolbar').html(
	    		'<a href="#!" class="btn btnB01 mt15">new</a>'
	    	);

	    	$('[name="selectForEmployee"]').change(function(){
	    		var val = $(this).val();
	    		if (val == 'yesAllEmployee') {
	    			$('#employeeList').hide(200);
	    		}
	    		else {
	    			$('#employeeList').show(200);	
	    		}
	    	})

	    	$('select#selectMethod').change(function(){
	    		/*$('#percentFrom').slideToggle(200);
	    		$('#exactValue').slideToggle(200);*/
	    		var val = $(this).val();
	    		if (val == 'percentFrom') {
	    			$('#percentFrom').show(200);
	    			$('#exactAmount').hide(200)
	    			$('#exactAmount').find('input[name="exact-amount"]').val('');
	    		}
	    		else {
	    			$('#percentFrom').hide(200);
	    			$('#exactAmount').show(200)	
	    			$('#percentFrom').find('input[name="percent-amount"]').val('');
	    		}
	    	});

	    	$('select#modalEdit-selectMethod').change(function(){
	    		/*$('#percentFrom').slideToggle(200);
	    		$('#exactValue').slideToggle(200);*/
	    		var val = $(this).val();
	    		if (val == 'percentFrom') {
	    			$('#modalEdit-percentFrom').show(200);
	    			$('#modalEdit-exactAmount').hide(200)
	    			$('#modalEdit-exactAmount').find('input[name="exact-amount"]').val('');
	    		}
	    		else {
	    			$('#modalEdit-percentFrom').hide(200);
	    			$('#modalEdit-exactAmount').show(200)	
	    			$('#modalEdit-percentFrom').find('input[name="percent-amount"]').val('');
	    		}
	    	});

	    	$('.newAdjustment').click(function(){
	    		var type = $(this).data('type');
	    		jQuery.get("{{route('payroll.adjustment.getid')}}/"+type,{},function(response){
		    		$('#modalNewAdjustment .type').text(type);
		    		$('#modalNewAdjustment form')[0].reset();
		    		$('#modalNewAdjustment input[name="transaction_id"]').val(response.id);
		    		$('#transaction-id').html(response.id);
		    		$('#modalNewAdjustment').openModal();
		    		$('#yesAllEmployee').click().change();
		    		$('#type_transaction').val(type);
		    		if (type != 'salary') {
		    			$('#modalNewAdjustment form').attr('action',"{{route('payroll.adjustment.new')}}");
		    			$('select#selectMethod').val('exactAmount').change();
		    			$('#selectMethodDiv').hide();
		    			$('#effectiveDateDiv').hide();
		    			$('#modalNewAdjustment #componentList').show(200);
		    			var selectContent = '<option value="" disabled="disabled" selected="selected">--Select--</option>';
		    			selectContent += response.component;
	    				$('#componentList').find('select').html(selectContent).material_select();
							
		    			// $('select#selectMethod option[value="percentFrom"]').html('% from current component').parent('select').material_select();
		    		} else {
		    			$('#modalNewAdjustment form').attr('action',"{{route('salary.new')}}");
		    			$('select#selectMethod').val('percentFrom').change();
		    			$('#selectMethodDiv').show();
		    			$('#effectiveDateDiv').show();
		    			$('#modalNewAdjustment #componentList').hide(200)
		    			// $('select#selectMethod option[value="percentFrom"]').html('% from current salary').parent('select').material_select();
		    		}
		    	});
	    	});

	    	$('.modal-trigger-edit').click(function(){
	    		var id = $(this).closest('tr').find('input[type="hidden"]').val();
	    		if($(this).data('type')=="salary") {
	    			$('select#modalEdit-selectMethod').val('percentForm').change();
	    			$('select#modalEdit-selectMethod').prop('disabled',false).material_select();
	    			// $('#modalEdit-selectMethodDiv').show();
	    		} else {
	    			$('select#modalEdit-selectMethod').val('exactAmount').change();
	    			$('select#modalEdit-selectMethod').prop('disabled',true).material_select();
	    			// $('#modalEdit-selectMethodDiv').hide();
	    		}
	    		$('#modalEditAdjustment input[name="transaction_id"]').val(id);
	    		$('#modalEditAdjustment').openModal();
	    	});

	    	$('.modal-trigger-delete').click(function(){
	    		var id = $(this).closest('tr').find('input[type="hidden"]').val();
	    		$('#modalDelete-id').val(id);
	    		$('#modalDeleteChanges').openModal();
	    	});

		    $('#yesDeleteChanges').click(function(){
		      $(this).addClass('disabled');
		      $(this).prev().addClass('disabled');
		      var id= $('#modalDelete-id').val();
		      $.post('{{route("payroll.adjustment.delete")}}/'+id) //{ _token: "{{ csrf_token() }}",data:deleteReimbursementID})
		      .done(function( data ) {
		        if (data.status = 'success'){
		          Materialize.toast('Deleted Successfully <i class="fa fa-check ml25"></i>', 3000,'teal');
		          $(this).removeClass('disabled');
		          $(this).prev().removeClass('disabled');
		          window.location.href = data.url;
		          window.location.reload();
		        }
		      });
		    });

	    })
    </script>
@endsection
@section('content')
<?php 
	$generalHeaderButton = '<a class="linkB01">Back to payroll menu</a>'
?>
@include('layouts.headers.general')
	<div class="container mt30">
		<div class="col l12 m12 s12">
			<div class="row">
		      <div class="col s12">
		        <nav class="nav3 tab3">
		              <div class="nav-wrapper">
		                <ul id="tabs3">
		                  <li class="tab text-uppercase ls2 pad-l-n"><a href="#salary" class="lato-black f12">Salary</a></li>
		                  <li class="tab text-uppercase ls2"><a href="#allowance" class="lato-black f12">Allowance</a></li>
		                  <li class="tab text-uppercase ls2"><a href="#deduction" class="lato-black f12">Deduction</a></li>
		                </ul>
		              </div>
		          </nav>
		      </div>
		    </div>

		    <div class="tab-content" id="salary">
				<div class="row">
					<div class="col l3">
		    			<a href="#!" class="btn btn02 mt20 newAdjustment" data-type="salary">new salary</a>
		    		</div>
			      	<div class="col l3 right">
			        	<input type="text" class="search" placeholder="Search" id="searchLive">
			      	</div>
			    </div>
			    <div class="row">
			      <div class="col l12 positionRelative">
			        <div class="w100p uiGridHeader">
			        </div>
			        <div class="w100p h370 overflowAuto">
			          <table class="table tableHover" id="tableRunPayroll">
			            <thead class="grey lighten-3 bold">
							<tr>
								<th width="120">Transaction ID</th>
								<th width="120">Effective Date</th>
								<th width="150">Changes</th>
								<th>Employee Name</th>
								<th width="150"></th>
							</tr>
			            </thead>
			            <tbody>
			            	@foreach($salaryTransactions as $row)
			            	<tr>
			            		<input type="hidden" value="{{$row['id']}}">
			            		<td>{{$row['transaction_id']}}</td>
			            		<td>{{Carbon\Carbon::parse($row['effective_date'])->format('d F Y')}}</td>
			           			<td>{{$row['changes']}}</td>
			            		<td data-tooltip="
				            		@foreach( $row['salary_history'] as $history)
				            			{{$history['employee']['first_name']}} {{$history['employee']['last_name']}}, 
			            			@endforeach
			            		">
			            			<p class="truncate">
				            		@foreach( $row['salary_history'] as $history)
				            			{{$history['employee']['first_name']}} {{$history['employee']['last_name']}}, 
			            			@endforeach
			            			</p>
			            		</td>
			            		<td>
			            			<a href="#!" class="red1-text link1 modal-trigger-edit" data-type="salary"><i class="fa fa-edit"></i>edit</a>
			            			<a href="#!" class="red1-text link1 modal-trigger-delete"><i class="fa fa-times"></i>delete</a>
			            		</td>
			            	</tr>
			            	@endforeach
			            </tbody>
			          </table>
			        </div>
			      </div>
			    </div>
		    </div>

		    <div id="allowance" class="tab-content">
		    	<div class="row">
		    		<div class="col l3">
		    			<a href="#!" class="btn btn02 mt20 newAdjustment" data-type="allowance">new allowance</a>
		    		</div>
			      	<div class="col l3 right">
			        	<input type="text" class="search" placeholder="Search" id="searchLive">
			      	</div>
			    </div>
			    <div class="row">
			      <div class="col l12 positionRelative">
			        <div class="w100p uiGridHeader">
			        </div>
			        <div class="w100p h370 overflowAuto">
			          <table class="table tableHover" id="tableRunPayroll">
			            <thead class="grey lighten-3 bold">
							<tr>
								<th width="120">Transaction ID</th>
								<!-- <th width="120">Effective Date</th> -->
								<th width="150">Changes</th>
								<th>Employee Name</th>
								<th width="150"></th>
							</tr>
			            </thead>
			            <tbody>
			            	@foreach($allowanceTransactions as $row)
			            	<tr>
			            		<input type="hidden" value="{{$row['id']}}">
			            		<td>{{$row['transaction_id']}}</td>
		{{--            		<td>{{Carbon\Carbon::parse($row['effective_date'])->format('d F Y')}}</td>
		--}}
			           			<td>{{$row['changes']}}</td>
			            		<td data-tooltip="
				            		@foreach( $row['payroll_component_employee'] as $history)
				            			{{$history['employee']['first_name']}} {{$history['employee']['last_name']}}, 
			            			@endforeach
			            		">
			            			<p class="truncate">
				            		@foreach( $row['payroll_component_employee'] as $history)
				            			{{$history['employee']['first_name']}} {{$history['employee']['last_name']}}, 
			            			@endforeach
			            			</p>
			            		</td>
			            		<td>
			            			<a href="#!" class="red1-text link1 modal-trigger-edit"><i class="fa fa-edit"></i>edit</a>
			            			<a href="#!" class="red1-text link1 modal-trigger-delete"><i class="fa fa-times"></i>delete</a>
			            		</td>
			            	</tr>
			            	@endforeach
			            </tbody>
			          </table>
			        </div>
			      </div>
			    </div>
		    </div>

		    <div id="deduction" class="tab-content">
		    	<div class="row">
		    		<div class="col l3">
		    			<a href="#!" class="btn btn02 mt20 newAdjustment" data-type="deduction">new deduction</a>
		    		</div>
					<div class="col l3 right">
						<input type="text" class="search" placeholder="Search" id="searchLive">
					</div>
			    </div>
			    <div class="row">
			      <div class="col l12 positionRelative">
			        <div class="w100p uiGridHeader">
			        </div>
			        <div class="w100p h370 overflowAuto">
			          <table class="table tableHover" id="tableRunPayroll">
			            <thead class="grey lighten-3 bold">
							<tr>
								<th width="120">Transaction ID</th>
								<!-- <th width="120">Effective Date</th> -->
								<th width="150">Changes</th>
								<th>Employee Name</th>
								<th width="150"></th>
							</tr>
			            </thead>
			            <tbody>
			            	@foreach($deductionTransactions as $row)
			            	<tr>
			            		<input type="hidden" value="{{$row['id']}}">
			            		<td>{{$row['transaction_id']}}</td>
			           			<td>{{$row['changes']}}</td>
			            		<td data-tooltip="
				            		@foreach( $row['payroll_component_employee'] as $history)
				            			{{$history['employee']['first_name']}} {{$history['employee']['last_name']}}, 
			            			@endforeach
			            		">
			            			<p class="truncate">
				            		@foreach( $row['payroll_component_employee'] as $history)
				            			{{$history['employee']['first_name']}} {{$history['employee']['last_name']}}, 
			            			@endforeach
			            			</p>
			            		</td>
			            		<td>
			            			<a href="#!" class="red1-text link1 modal-trigger-edit"><i class="fa fa-edit"></i>edit</a>
			            			<a href="#!" class="red1-text link1 modal-trigger-delete"><i class="fa fa-times"></i>delete</a>
			            		</td>
			            	</tr>
			            	@endforeach
			            </tbody>
			          </table>
			        </div>
			      </div>
			    </div>
		    </div>
		</div>
	</div>

	<!-- Modal Set New Adjustment -->
	<div id="modalNewAdjustment" class="modal modal-fixed-footer modal2">
		<form action="">
			<div class="modal-content">
			  	<h4 class="titleB01 mb5 text-capitalize">Set New <span class="type">Salary</span></h4>
			  	<div class="row mb5">
				  <div class="col l12">
				  	<p>Transaction ID <span id="transaction-id" class="bold">20180005</span></p>
				  	<input type="hidden" name="transaction_id">
				  	<input type="hidden" name="type" id="type_transaction">
				  </div>
				  <div class="col l12 mt30">
				  	<p>Do you want to make <span class="type">salary</span> changes for all employees?</p>
				  </div>
				  <div class="col l12 input-field mt0">
				  	<input type="radio" name="selectForEmployee" class="with-gap" value="yesAllEmployee" id="yesAllEmployee" checked="checked">
				  	<label for="yesAllEmployee">Yes</label>
				  </div>
				  <div class="col l12 input-field mt0">
				  	<input type="radio" name="selectForEmployee" class="with-gap" value="noOnlySelected" id="noOnlySelected">
				  	<label for="noOnlySelected">No, only for selected employees</label>
				  </div>
			  	</div>
			  	<div class="row mb5 displayNone" id="employeeList">
			  		<div class="col l12">
			  			@include('employee/list')
			  		</div>
			  	</div>
			  	<div class="row mb5 displayNone" id="componentList">
			  		<div class="col l12 input-field mt40">
					  	<select name="component_id_fk">
					  	</select>
					  	<label>Payroll Component</label>
					</div>
			  	</div>
			  	<div id="selectMethodDiv" class="row mb5">
			  		<div class="col l12 input-field mt40">
					  	<select id="selectMethod" name="selectMethod">
					  		<option value="percentFrom">% From Current <span class="type">Salary</span></option>
					  		<option value="exactAmount">Exact Amount</option>
					  	</select>
					  	<label>Select Method</label>
					</div>
			  	</div>
			  	<div class="row" id="percentFrom">
			  		<div class="col l4 input-field mt5">
					  	<select class="browser-default default4" name="percent-addsub">
					  		<option value>+</option>
					  		<option value="-">-</option>
					  	</select>
					  	<span></span>
					  	<input type="text" maxlength="3" class="input1" name="percent-amount">
				  	</div>
				  	<div class="col l8 pad-l-n">
				  		<p class="bold mt10">% from current <span class="type">salary</span></p>
				  	</div>
			  	</div>
			  	<div class="row displayNone" id="exactAmount">
			  		<div class="col l12 input-field mt5">
					  	<select class="browser-default default4" name="exact-addsub">
					  		<option value="+">+</option>
					  		<option value="-">-</option>
					  	</select>
					  	<span></span>
					  	<input type="text" class="input1" name="exact-amount">
				  	</div>
			  	</div>
			  	<div class="row" id="effectiveDateDiv">
			  		<div class="col l12 input-field">
			  			<input type="text" class="datepicker form_clearDate" id="effective_date" name="effective_date">
			  			<label for="effective_date">Effective date</label>
			  		</div>
			  	</div>
			</div>
			<div class="modal-footer footerModal">
			  <a href="#!" class="submitButton btn btnB01">Save</a>
			  <a href="#!" class="modal-action modal-close btn btnB01">Cancel</a>
			</div>
			<input class="text_success" type="hidden" value="New salary successfully created">
		</form>
	</div>


	<!-- Modal Edit Adjustment -->
	<div id="modalEditAdjustment" class="modal modal-fixed-footer modal1">
		<form action="{{route('payroll.adjustment.edit')}}">
			<div class="modal-content">
			  	<h4 class="titleB01 mb5 text-capitalize">Edit <span class="type">Salary</span></h4>
			  	<input type="hidden" name="transaction_id">
			  	<input type="hidden" name="effective_date" value=2000-01-01> {{-- buat lewatin validasi request aja --}}
			  	<div id="modalEdit-selectMethodDiv" class="row mb5">
			  		<div class="col l12 input-field mt40">
					  	<select id="modalEdit-selectMethod" name="selectMethod">
					  		<option value="percentFrom">% From Current <span class="type">Salary</span></option>
					  		<option value="exactAmount">Exact Amount</option>
					  	</select>
					  	<label>Select Method</label>
					</div>
			  	</div>
			  	<div class="row" id="modalEdit-percentFrom">
			  		<div class="col l4 input-field mt5">
					  	<select class="browser-default default4" name="percent-addsub">
					  		<option value>+</option>
					  		<option value="-">-</option>
					  	</select>
					  	<span></span>
					  	<input type="text" maxlength="3" class="input1" name="percent-amount">
				  	</div>
				  	<div class="col l8 pad-l-n">
				  		<p class="bold mt10">% from current <span class="type">salary</span></p>
				  	</div>
			  	</div>
			  	<div class="row displayNone" id="modalEdit-exactAmount">
			  		<div class="col l12 input-field mt5">
					  	<select class="browser-default default4" name="exact-addsub">
					  		<option value="+">+</option>
					  		<option value="-">-</option>
					  	</select>
					  	<span></span>
					  	<input type="text" class="input1" name="exact-amount">
				  	</div>
			  	</div>
			</div>
			<div class="modal-footer footerModal">
			  <a href="#!" class="submitButton btn btnB01">Save</a>
			  <a href="#!" class="modal-action modal-close btn btnB01">Cancel</a>
			</div>
			<input class="text_success" type="hidden" value="New salary successfully created">
		</form>
	</div>

	{{-- modal delete salary changes --}}
	<div id="modalDeleteChanges" class="modal modal-fixed-footer modal-confirm">
	  <div class="modal-content">
	  	<input type="hidden" id="modalDelete-id">
	    <h4 class="titleB01">Delete?</h4>
	    <div class="row">
	      <div class="col l12 s12 input-field">
	        <p>Are you sure want to delete this changes?</p>
	      </div>
	    </div>
	  </div>
	  <div class="modal-footer">
	    <a href="#!" class="modal-action modal-close btn btnB01">No</a>
	    <a href="#!" class="btn btnB01 mr5" id="yesDeleteChanges">Yes</a>
	  </div>
	</div>

@endsection
