@section('personalHtml')
<li id="personalData" class="row overflow-y-auto">
  <div class="container">
    {!! Form::open(array('url' => 'employee/create/validatePersonal')) !!}
      <div class="col l12 s12 hide-on-small-only">
        <p class="lato-light red1-text f25">Personal Data</p>
      </div>
      <!-- First -->
      @if(Sentinel::getUser()->userAccessConnection->employee_id_fk==NULL)
      <div class="col l12 s12 input-field mb30">
        <input type="checkbox" id="firstEmployee" class="filled-in" name="first_register" value='yes'>
        <label for="firstEmployee">Is this you?</label>
      </div>
      @endif
      <div class="col l4 m6 s12 input-field">
        <?= Form::text('first_name','',array('id'=>'first_name','class'=>'validate')) ?>
        <label for="first_name">First Name*</label>
      </div>
      <div class="col l4 m6 s12 input-field">
        <?= Form::text('last_name','',array('id'=>'last_name','class'=>'validate')) ?>
        <label for="last_name">Last Name</label>
      </div>
      <div class="col l4 m6 s12 input-field">
        <?= Form::text('employee_id','',array('id'=>'employee_id','class'=>'validate')) ?>
        <label for="employeeID">Employee ID*</label>
      </div>


      <div class="col l4 m6 s12 input-field">
        <?= Form::email('email','',array('id'=>'email','class'=>'validate enter')) ?>
        <label for="email">Email*</label>
      </div>
      <div class="col l4 m6 s12 input-field">
          <?= Form::text('mobile_phone','',array('id'=>'mobile_phone','class'=>'validate'))?>
          <label for="mobile_phone">Mobile Phone</label>
      </div>
      <div class="col l4 m6 s12 input-field">
          <?= Form::text('phone','',array('id'=>'phone','class'=>'validate'))?>
          <label for="phone">Phone</label>
      </div>


      <div class="col s12 input-field">
        <?= Form::textarea('address','',['class'=>'materialize-textarea', 'id'=> 'address_input'])?>
        <label for="address_input">Address</label>
      </div>
      <div id="addressBox" class="displayNone">
        <div class="col l6 s12 input-field">
          <input type="text" id="city" name="city">
          <label for="city">City</label>
        </div>
        <div class="col l6 s12 input-field">
            <?= Form::text('postal_code','',array('id'=>'postal_code','class'=>'validate enter')) ?>
            <label for="postal_code">Postal Code</label>
        </div>
      </div>


      <div class="col l4 m6 s12 input-field">
        <?= Form::select('identity_type', BaseService::getIdentityType(),'',['id'=>'identityType','class'=>'validate']);?>
        <label for="identityType">Identity Type*</label>
      </div>
      <div class="col l4 m6 s12 input-field">
        <?= Form::text('identity_number','',array('id'=>'identity_number','class'=>'validate')) ?>
        <label for="identity_number">No Identity</label>
      </div>
      <div class="col l4 m6 s12 input-field">
        <?= Form::text('identity_expired_date','',array('id'=>'identity_expired_date','class'=>' datepicker validate')) ?>
        <label for="identity_expired_date">Expired Date Identity</label>
      </div>


      <div class="col l4 m6 s12 input-field">
        <?= Form::text('place_of_birth','',array('id'=>'place_of_birth','class'=>'validate')) ?>
        <label for="place_of_birth">Place of Birth</label>
      </div>
      <div class="col l4 m6 s12 input-field">
        <?= Form::text('date_of_birth','',array('id'=>'date_of_birth','class'=>'datepicker-birth validate')) ?>
        <label for="date_of_birth">Date of Birth</label>
      </div>
      <div class="col l4 m6 s6 input-field">
        <?= Form::select('marital_status', BaseService::getMaritalStatus(),'',['id'=>'marital_status','class'=>'validate']);?>
        <label for="marital_status">Marital Status*</label>
      </div>


      <div class="col l4 m6 s6 input-field">
        <?= Form::select('gender', BaseService::getGender(),'',['id'=>'gender','class'=>'validate']);?>
        <label for="gender">Gender*</label>
      </div>

      <div class="col l4 s6 input-field">
        <?= Form::select('blood_type', BaseService::getBloodType(),'',['id'=>'blood_type','class'=>'validate']);?>
        <label for="blood_type">Blood Type*</label>
      </div>
      <div class="col l4 s6 input-field">
        <?= Form::select('religion', BaseService::getReligion(),'',['id'=>'religion','class'=>'validate']);?>
        <label for="religion">Religion*</label>
      </div>

      {!! Form::close() !!}

      <div class="col l12 s12 mt30 right-align">
        <a href="#!" class="btn btnB01 prevStep">Prev</a>
        <a href="#!" class="btn btnB01 nextStep" id="personalNext">Next</a>
      </div>
    </div>
</li>
@endsection
