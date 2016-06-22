<!-- Modal Request Time Off -->
<div id="modalRequestTimeOff" class="modal modal-fixed-footer modal2">
  {!! Form::open(array('url' => route('timeoff.request'),'class' => 'formJobDep', 'data-type' => 'departement')) !!}

    <div class="modal-content">
      <h4 class="titleB01">Request Time Off</h4>
      <hr class="mb20">
      <div class="row">
        <div class="col l12 m12 s12 input-field">
          <?= Form::select('policy_id_fk', UserService::getTimeOffPolicies(),null,['id'=>'policy_id_fk','class'=>'validate enter']); ?>
            <label for="policy_id_fk">Policy Name</label>
        </div>
        <div class="row">
          <div class="col l5 m5 s12 pad-l-n">
            <div class="col l12 m12 s12 input-field">
              <?= Form::text('start_date',null,array('id'=>'start_date','class'=>'datepicker form_clearDate')) ?>
                <label for="start_date">Start Date</label>
            </div>
          </div>
          <div class="col l7 m7 s12">
            <div class="switcher switcher2 mt15">
              <label>
                <input id="toggleHalfDay" name="half_day" value="1" type="checkbox" class="form_uncheck">
                <span class="full">Full Day</span>
                <span class="half">Half Day</span>
              </label>
            </div>
          </div>
        </div>
        <div id="endDateSection" class="row form_show">
          <div class="col l5 m5 s12 pad-l-n">
            <div class="col l12 m12 s12 input-field">
              <?= Form::text('end_date',null,array('id'=>'end_date','class'=>'datepicker')) ?>
                <label for="end_date">End Date</label>
            </div>
          </div>
        </div>
        <div class="col l12 m12 s12 input-field">
          <?= Form::textarea('reason',null,array('id'=>'reason','class'=>'validate enter materialize-textarea')) ?>
          <label for="reason">Reason</label>
        </div>
      </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close btn btnB01">Cancel</a>
        <a href="#!" class=" btn btnB01 submitButton">Request</a>
    </div>
    <input class="text_success" type="hidden" value="Request Sent"/>

    {!! Form::close() !!}
</div>
