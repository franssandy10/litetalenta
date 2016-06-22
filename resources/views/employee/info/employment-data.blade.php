@section('employmentDataHtml')
<div id="employmentData" class="col s12 pad-20 white">
  {!! Form::model($model,array('url' => route($type.'.employmentdata',['id'=>$model->id]))) !!}
  <input type="hidden" name="_method" value="PUT">
  <div class="row">
    <div class="col l4 m4 s12 input-field">
      <?= Form::select('employment_status', BaseService::getEmploymentStatus(),null,['id'=>'employment_status','class'=>'validate']);?>
      <label for="emplStat">Employment Status*</label>
    </div>
    <div class="col l4 m4 s12 input-field">
      <?= Form::text('join_date',null,array('id'=>'join_date','class'=>' datepicker validate')) ?>
      <label for="join_date">Join Date*</label>
    </div>
    <div class="col l4 m4 s12 input-field displayNone">
      <?= Form::text('end_contract_date',null,array('id'=>'end_contract_date','class'=>' datepicker validate')) ?>
      <label for="end_contract_date">End Contract Date*</label>
    </div>
    <div class="col l4 m4 s12 input-field displayNone">
      <?= Form::text('end_probation_date',null,array('id'=>'end_probation_date','class'=>' datepicker validate')) ?>
      <label for="end_probation_date">End Probation Date*</label>
    </div>
    
    <div class="col l4 m4 s12 input-field">
      <?= Form::select('department_id_fk', UserService::getListDepartment(),null,['id'=>'department_id_fk','class'=>'validate']);?>
      <label for="orgName">Department*</label>
    </div>
    <div class="col l4 m4 s12 input-field">
      <?= Form::select('job_position_id_fk', UserService::getListJobPosition(),null,['id'=>'job_position_id_fk','class'=>'validate']);?>
      <label for="jobPos">Job Position*</label>
    </div>
  </div>
  <div class="row">
    <div class="col l12 right-align">
      <a href="#!" class="btn btnB01 submitButton">save employment data</a>
    </div>
  </div>
  <input class="text_success" type="hidden" value="Update Employment Successfull"/>
  {!! Form::close() !!}
</div>
@endsection
