@section('companyDetailHtml')
<!-- Company Detail -->
<li id="companyDetail">
  <div class="container">
    <div class="row">
      {!! Form::open(array('url' => 'employee/create/validateCompanyDetail')) !!}
        <div class="col l12 s12 hide-on-small-only mb20">
          <p class="lato-light red1-text f25">Company Detail</p>
        </div>
        <!-- First -->
        <!-- <div class="col l6 s12 input-field">
          <input type="text" id="cName" disabled="disabled" value="{{$company_detail['name']}}">
          <label for="cName">Company Name</label>
        </div> -->
        <div class="col l4 m6 s12 input-field">
          <?= Form::select('employment_status', BaseService::getEmploymentStatus(),'',['id'=>'employment_status','class'=>'validate']);?>
          <label for="employment_status">Employment Status*</label>
        </div>
        <div class="col l4 m6 s12 input-field">
          <?= Form::text('join_date','',array('id'=>'join_date','class'=>' datepicker validate')) ?>
          <label for="join_date">Join Date*</label>
        </div>
        <div class="col l4 m6 s12 input-field displayNone">
          <?= Form::text('end_contract_date','',array('id'=>'end_contract_date','class'=>' datepicker validate')) ?>
          <label for="end_contract_date">End Contract Date*</label>
        </div>
        <div class="col l4 m6 s12 input-field displayNone">
          <?= Form::text('end_probation_date','',array('id'=>'end_probation_date','class'=>' datepicker validate')) ?>
          <label for="end_probation_date">End Probation Date*</label>
        </div>
        <!-- 
        <div class="col l4 m6 s12 input-field">
          <select id="access_role">
            <option value="employee">Employee</option>
            <option value="admin">Admin</option>
            <option value="superadmin">Superadmin</option>
          </select>
          <label for="access_role">Access Role</label>
        </div> -->
        <div class="col l4 s12 input-field">
          <?= Form::select('department_id_fk', UserService::getListDepartment(),'',['id'=>'department_id_fk','class'=>'validate']);?>
          <label for="department_id_fk">Department</label>
          <a href="#!"  class="red1-text addNewBox"><i class="talenta-tambah displayInlineBlock"></i> Add new department</a>
          <div id="add_department" class="addNewBox">
            <input type="text">
            <a href="#!" class="btnB02">Add</a>
          </div>
        </div>
        <div class="col l4 s12 input-field">
          <?= Form::select('job_position_id_fk', UserService::getListJobPosition(),'',['id'=>'job_position_id_fk','class'=>'validate']);?>
          <label for="job_position_id_fk">Job Position</label>
          <a href="#!" class="red1-text addNewBox"><i class="talenta-tambah displayInlineBlock"></i> Add job position</a>
          <div id="add_job" class="addNewBox">
            <input type="text">
            <a href="#!" class="btnB02">Add</a>
          </div>
        </div>
      {!! Form::close() !!}
      <div class="col l12 s12 mt30 right-align">
        <a href="#!" class="btn btnB01 prevStep">Prev</a>
        <a href="#!" class="btn btnB01 nextStep">Next</a>
      </div>
    </div>
  </div>
</li>

@endsection
