<!-- Modal Create Policy Time Off -->
<div id="modalAddTimeoff" class="modal modal-fixed-footer modal2">
	{!! Form::open(array('url' => route('timeoff.create'))) !!}
		<div class="modal-content">
		  <h4 class="titleB01">Create New Policy</h4>
		  <hr class="mb20">
	    	<div class="row">
	    		<div id="createPolicyField">
		    		<div class="col l12 m12 s12 input-field">
	      				<?= Form::text('policy_code',null,array('id'=>'policy_code','class'=>'validate enter')) ?>
						<label for="policy_code">Policy Code</label>
					</div>
					<div class="col l12 m12 s12 input-field">
	      				<?= Form::text('name',null,array('id'=>'name','class'=>'validate enter')) ?>
						<label for="name">Policy Name</label>
					</div>
					<div class="col l12 m12 s12 input-field">
	      				<?= Form::text('effective_date',null,array('id'=>'effective_date','class'=>'datepicker form_clearDate')) ?>
						<label for="effective_date">Effective as of</label>
					</div>
					<div class="col l12 m12 s12 input-field mb20">
						<?= Form::checkbox('unlimited_flag', 1, true, ['class' => 'filled-in','id'=>'unlimited_flag']) ?>
						<label for="unlimited_flag">This policy has unlimited time off</label>
					</div>
					<div id="inputBalance" class="displayNone mt25">
						<div class="row">
							<div class="col s4 offset-s1 input-field">
								<input type="text" id="balance" name="balance">
								<label for="balance">Balance in days</label>
							</div>
							<div class="col s6">
								<p class="mt30">days per year</p>
							</div>
						</div>
						<!-- <div class="row">
						      <div class="col s5 input-field">
						        <input name="assign_date" type="text" class="datepicker form_default">
						        <label>Assign Date</label>
						      </div>
						      <div class="col input-field">
						        <p class="mt10">to</p>
						      </div>
						      <div class="col s5 input-field">
						        <input name="expired_date" type="text" class="datepicker form_default" disabled>
						        <label class="grey-text"><strike>Expired Date</strike></label>
						      </div>
					    </div> -->
						<div class="clearfix"></div>
					</div>
				</div>

				<?= Form::hidden('approver_list',Sentinel::getUser()->id.',',
				array('id'=>'approver_list')) ?>
				<div class="col s12 input-field">
					<p class="bold mb0">Ask Approval from</p>
					<input type="checkbox" class="filled-in" id="you" checked="checked">
					<label for="you" class="bold">You</label>
				</div>
				@if (count($users)>0)
				<div class="col s12 input-field">
				  <input type="checkbox" class="filled-in" id="other">
				  <label for="other" class="bold">Other employee</label>
				</div>
				<div class="col s11 offset-s1 pad-l-n mt10 displayNone" id="otherEmployeeList">
				  @include('reimbursement/partials/userlist')
				</div>
				@endif

				<div class="col l12 m12 s12 input-field">
					<input type="hidden" id="modalEP-id" name="modalEP-id">
					<input type="checkbox" class="filled-in" checked="checked" id="default_flag" name="default_flag" value="1">
					<label for="default_flag">Set as default timeoff for new employee</label>
				</div>
				<div class="col l12 m12 s12 input-field">
					<input type="checkbox" id="allEmployee" class=" filled-in" name="allEmployee">
					<label for="allEmployee">Valid for employee</label>
				</div>
				<div class="col s11 offset-s1 pad-l-n mt20" id="employeeListWrap">
					@include('employee/useraccessconnlist')
				</div>
	    	</div>
		</div>
		<div class="modal-footer">
		  <a  class="modal-action modal-close btn btnB01">Cancel</a>
		  <a  class="btn btnB01 mr5 submitButton" id="addTimeOff">Save</a>
		</div>
		<input class="text_success" type="hidden" value="Successfully created new policy">
	{!!Form::close()!!}
</div>