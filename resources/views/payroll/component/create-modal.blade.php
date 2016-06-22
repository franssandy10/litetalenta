<div id="modalCreatePayrollComponent" class="modal modal-fixed-footer modal2">
	{!! Form::open(array('route' => 'payrollcomponent.add')) !!}
	    <div class="modal-content">
	      <h4 class="titleB01 mb0 pad-l-n text-capitalize titleModalCreatePayrollComponent">Add <span class="titleModalComponent">Payroll</span> Component</h4>
	      <div class="row">
					<?= Form::hidden('component_type',null,array('id'=>'component_type')) ?>

	      	<div class="col s12 input-field">
						<?= Form::text('component_name','',array('id'=>'component_name','class'=>'validate enter')) ?>
	      		<label for="component_name">Component Name</label>
	      	</div>
	      	<div class="col s12 input-field">
						<?= Form::text('component_amount','0',array('id'=>'component_amount','class'=>'validate enter money')) ?>
	      		<label for="component_amount">Component Amount</label>
	      	</div>
	      	<div class="col s12 input-field">
						<?= Form::select('component_type_occur', [1=>'Monthly',2=>'Daily',3=>'One Time'],1,['id'=>'component_type_occur','class'=>'validate']); ?>
	      		<label>Type</label>
	      	</div>
	      	<?php /*
	      	<div class="col s12 input-field mb40 mt0" id="prorateDiv">
						<?= Form::checkbox('prorate_flag',1,false,array('id'=>'prorate_component','class'=>'filled-in')) ?>
	      		<label for="prorate_component">Prorate</label>
	      	</div>
	      	*/ ?>
	      	<div class="col s12 input-field">
						<?= Form::select('component_tax_type', ['1'=>'Taxable','2'=>'Non-taxable'],'',['class'=>'validate']); ?>
	      		<label>Tax Status</label>
	      	</div>
	      	<div class="col s12 input-field mt0">
						<?= Form::checkbox('default_flag',1,false,array('id'=>'default_flag','class'=>'filled-in')) ?>
	      		<label for="default_flag">Set as default for new employee</label>
	      	</div>
	      	<div id="employeeAttachment">
		      	<div class="col s12 input-field">
							<?= Form::checkbox('valid_for_all',1,false,array('id'=>'valid_for_all','class'=>'filled-in  closeSearchEmployee')) ?>
		      		<label for="valid_for_all">This allowance is valid for all employee</label>
		      	</div>
		      	<div class="col offset-s1 s11 mt15">
		      		@include('employee.list')
		      	</div>
	      	</div>
	      </div>
	    </div>
	    <div class="modal-footer">
			<a href="#!" class="modal-action modal-close btn btnB01">Cancel</a>
	      	<a href="#!" class="modal-action btn btnB01" id="addPayrollCompBtn">Confirm</a>
	    </div>
	{!! Form::close() !!}
</div>

<!-- Modal Delete Component-->
<div id="modalDeleteComponent" class="modal modal-fixed-footer modal-confirm">
	<div class="modal-content">
	  <h4 class="titleB01">Delete?</h4>
	  <div class="row">
	  	<div class="col l12 s12 input-field">
	  		<p>Are you sure want to delete this component?</p>
	  	</div>
	  </div>
	</div>
	<div class="modal-footer">
	  <a href="#!" class="modal-action modal-close btn btnB01">No</a>
	  <a href="#!" class="modal-action modal-close btn btnB01 mr5" id="yesDeleteComponentCreated">Yes</a>
	</div>
</div>

@section('createcompjs')
	<script type="text/javascript">
		$(document).ready(function(){
			$('#addPayrollCompBtn').click(function(){
				$form = $(this).closest('form');
				var type = $form.find('.titleModalComponent').text().toLowerCase();

				var $function = function(data){
					titleComponent = $form.find('#component_name').val();
					parentType = $('#payrollComponentTable').find('.componentWrapperColumn[data-type="' + type + '"]');
					html = 	'<div class="grey lighten-3 pad-10 displayInlineBlock maxWidth100p mr5 componentWrapper" data-view="' + data.view + '" data-tooltip="' + titleComponent + '">' +
								'<p class="left mr5 truncate">' + titleComponent + '</p>' +
								'<a data-url="' + data.delete + '" class="right grey-text cursorPointer bold delComponent"><i class="fa fa-times"></i></a>' +
							'</div>';
					$(parentType).append(html);
				}
				validateForm($form, $function)
			});

			$('#yesDeleteComponentCreated').click(function(){
				var url = $(this).data('url');
				console.log(url)
				$.ajax({
					url: url,
					method:"POST",
					dataType:'JSON',
					success: function(data){
						$('#payrollComponentTable').find('.delComponent[data-url="' + url + '"]').closest('.displayInlineBlock').slideUp(300).remove();
					},
					error: function(){

					}
				})
			})
		})
	</script>
@endsection