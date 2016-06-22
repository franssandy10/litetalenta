<!-- Modal Create Policy Reimbursement -->
<div id="modalAddReimbursement" class="modal modal-fixed-footer modal2">
<input type="hidden" id="userID" value="{{Sentinel::getUser()->id}}">
  {!! Form::open(array('url' => route('reimbursement.create'))) !!}
  <div class="modal-content">
    <h4 class="titleB01">Create New Policy</h4>
    <hr class="mb20">
      <div class="row">
        <div id="createPolicyField">
          <div class="col l12 m12 s12 input-field">
              <?= Form::text('name',null,array('id'=>'name','class'=>'validate enter')) ?>
              <label for="name">Policy Name</label>
          </div>
          <div class="col s12 input-field">
              <?= Form::text('effective_date',null,array('id'=>'effective_date','class'=>'datepicker')) ?>
              <label for="effective_date">Effective Date</label>
          </div>
          <div class="col l12 m12 s12 input-field  mb30">
              <?= Form::checkbox('unlimited_flag', 'unlimited', true, ['class' => 'filled-in','id'=>'unlimited_flag']) ?>
              <label for="unlimited_flag">This policy has unlimited limit</label>
          </div>
          <div id="inputBalance" class="displayNone mt25 ">
            <div class="row">
                <div class="col s6 input-field">
                  <?= Form::text('limit',null,array('id'=>'limit','class'=>'money')) ?>
                  <label for="limit">Limit</label>
                </div>

                <div class="col s6 input-field">
                  <select id="limit_type" class="form_default" name="limit_type">
                    <option value="1">Per Claim</option>
                    <option value="2">Monthly</option>
                    <option value="3">Yearly</option>
                  </select>
                </div>
            </div>
          </div>
        </div>
      <?= Form::hidden('approver_list',Sentinel::getUser()->id.',',
        array('id'=>'approver_list')) ?>
      <div class="col s12 input-field">
        <p class="bold">Ask Approval from</p>
        <input type="checkbox" class="filled-in" id="you" checked="checked">
        <label for="you" class="bold">You</label>
      </div>
      @if (count($users)>0)
        <div class="col s12 input-field">
          <input type="checkbox" class="filled-in" id="other" checked="checked">
          <label for="other" class="bold">Other employee</label>
        </div>
        <div class="col s11 offset-s1 pad-l-n mt10" id="otherEmployeeList">
          @include('reimbursement/partials/userlist')
        </div>
      @endif

        <div class="col l12 m12 s12 input-field">
          <input type="hidden" id="modalEP-id" name="modalEP-id">
          <input type="checkbox" class="filled-in" checked="checked" id="default_flag" name="default_flag" value="1">
          <label for="default_flag">Set as default reimbursement for new employee</label>
        </div>
        <div class="col l12 m12 s12 input-field">
          <input type="checkbox" id="allEmployee" class=" filled-in" name="allEmployee">
          <label for="allEmployee">This policy is valid for all employee</label>
        </div>
        <div class="col s11 offset-s1 pad-l-n mt20" id="employeeListWrap">
          @include('employee/useraccessconnlist')
        </div>
      </div>
  </div>
  <div class="modal-footer">
    <a class="modal-action modal-close btn btnB01">Cancel</a>
    <a class="btn btnB01 mr5" id="addReimbursement">Create</a>
  </div>
    <input id="" class="text_success" type="hidden" value="Successfull Create Policy"/>
  {!!Form::close()!!}
</div>
