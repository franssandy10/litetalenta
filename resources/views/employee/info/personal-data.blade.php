@section('personalDataHtml')
<div id="personalData" class="col s12 pad-20 white">
  {!! Form::model($model,array('url' => route($type.'.personaldata',['id'=>$model->id]))) !!}
  <input type="hidden" name="_method" value="PUT">
    <div class="row">
      
      <div class="col l4 m4 s12 input-field">
        <?= Form::text('first_name',null,array('id'=>'first_name','class'=>'validate enter_disabled')) ?>
        <label for="first_name">First Name</label>
      </div>
      <div class="col l4 m4 s12 input-field">
        <?= Form::text('last_name',null,array('id'=>'last_name','class'=>'validate enter_disabled')) ?>
        <label for="last_name">Last Name</label>
      </div>
      <div class="col l4 m4 s12 input-field">
        <?= Form::text('employee_id',null,array('id'=>'employee_id','class'=>'validate enter_disabled')) ?>
        <label for="employee_id">Employee ID*</label>
      </div>

      <div class="col l4 m4 s12 input-field">
        <?= Form::text('email',null,array('id'=>'email','class'=>'validate enter_disabled')) ?>
        <label for="email">Email</label>
      </div>
      <div class="col l4 m4 s12 input-field">
        <?= Form::text('mobile_phone',null,array('id'=>'mobile_phone','class'=>'validate enter_disabled')) ?>
        <label for="mobile_phone">Mobile Phone</label>
      </div>
      <div class="col l4 m4 s12 input-field">
        <?= Form::text('phone',null,array('id'=>'phone','class'=>'validate enter_disabled')) ?>
        <label for="phone">Phone</label>
      </div>

      <div class="col l12 m12 s12 input-field">
        <?= Form::textarea('address',null,array('id'=>'address','class'=>'validate enter_disabled materialize-textarea')) ?>
        <label for="address">Address</label>
      </div>
      <div class="col l6 m6 s12 input-field">
        <?= Form::text('city',null,array('id'=>'city','class'=>'validate enter_disabled')) ?>
        <label for="city">City</label>
      </div>
      <div class="col l6 m6 s12 input-field">
        <?= Form::text('postal_code',null,array('id'=>'postal_code','class'=>'validate enter_disabled')) ?>
        <label for="postal_code">Postal Code</label>
      </div>

      <!-- <div class="col l6 m6 s12 input-field">
        <?= Form::text('barcode',null,array('id'=>'barcode','class'=>'validate enter_disabled')) ?>
        <label for="barcode">Barcode</label>
      </div> -->
      
      <div class="col l4 m4 s12 input-field">
          <?= Form::select('identity_type', BaseService::getIdentityType(),null,['id'=>'identity_type','class'=>'validate enter_disabled']); ?>
        <label for="identity_type">Identity Type</label>
      </div>
      <div class="col l4 m4 s12 input-field">
        <?= Form::text('identity_number',null,array('id'=>'identity_number','class'=>'validate enter_disabled')) ?>
        <label for="identity_number">No Identity</label>
      </div>
      <div class="col l4 m4 s12 input-field">
        <?= Form::text('identity_expired_date',null,array('id'=>'identity_expired_date','class'=>'validate enter_disabled datepicker')) ?>
        <label for="identity_expired_date">Expired Date Identity</label>
      </div>
      
      <div class="col l4 m4 s12 input-field">
        <?= Form::text('place_of_birth',null,array('id'=>'place_of_birth','class'=>'validate enter_disabled')) ?>
        <label for="place_of_birth">Place of Birth</label>
      </div>
      <div class="col l4 m4 s12 input-field">
        <?= Form::text('date_of_birth',null,array('id'=>'date_of_birth','class'=>'validate enter_disabled datepicker')) ?>
        <label for="date_of_birth">Birth Date</label>
      </div>
      <div class="col l4 s4 input-field mt30-small">
        <?= Form::select('marital_status', BaseService::getMaritalStatus(),null,['id'=>'marital_status','class'=>'validate enter_disabled']); ?>
        <label>Marital Status</label>
      </div>

      <div class="col l4 s4 input-field mt30-small">
        <?= Form::select('gender', BaseService::getGender(),null,['id'=>'gender','class'=>'validate enter_disabled']); ?>
        <label>Gender</label>
      </div>
      <div class="col l4 s4 input-field mt30-small">
        <?= Form::select('blood_type', BaseService::getBloodType(),null,['id'=>'blood_type','class'=>'validate enter_disabled']); ?>
        <label>Blood Type</label>
      </div>
      <div class="col l4 s4 input-field mt30-small">
        <?= Form::select('religion', BaseService::getReligion(),null,['id'=>'religion','class'=>'validate enter_disabled']); ?>
        <label>Religion</label>
      </div>


      
      <!-- <div class="col l4 m4 s12 mt0">
        <p>Gender</p>
        <div class="col l4 input-field pad-l-n mt0">
          <?= Form::radio('gender',1,($model->gender==1)? true:false ,array('id'=>'male','class'=>'with-gap')) ?>
          <label for="male">Male</label>
        </div>
        <div class="col l6 input-field mt0">
          <?= Form::radio('gender',2,($model->gender==1)? true:false,array('id'=>'female','class'=>'with-gap')) ?>
          <label for="female">Female</label>
        </div>
      </div> -->
    </div> <!-- Row -->
    <input type="hidden" class="text_success" value="Personal Info Updated"/>

    <div class='row'>
      <div class="col l12 m12 s12 right-align mt30">
        <a href="#!" class="btn btnB01 submitButton">save personal data</a>
      </div>
    </div>
  {!! Form::close() !!}
</div>
@endsection
