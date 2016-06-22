@section('changePasswordHtml')
<div class="row">

  {!! Form::model($model_user,array('url' => route('settingchangepassword'))) !!}
  <p class="titleB01 mt40">Change Password</p>
  <hr class="mt10 mb20">
  <div class="col l6 input-field">
    <?= Form::password('current_password',array('id'=>'current_password','class'=>'validate enter')) ?>
    <label for="current_password">Current Password</label>
  </div>
  <div class="clearfix"></div>
  <div class="col l6 input-field">
    <?= Form::password('new_password',array('id'=>'new_password','class'=>'validate enter')) ?>
    <label for="new_password">New Password</label>
  </div>
  <div class="col l1">
      <a id="tooltipPass" class="blue-text tooltip2 tooltip2-right hovered">
        <i class="fa fa-info-circle mt40"></i>
        <span class="left-align">
          <ul class="fa-ul f11">
            <li class="red1-text"><i class="fa-li fa fa-times" id="length"></i>At least 6 characters</li>
            <li class="red1-text"><i class="fa-li fa fa-times" id="letter"></i>Contains letter</li>
            <li class="red1-text"><i class="fa-li fa fa-times" id="number"></i>Contains number</li>
            <li class="red1-text"><i class="fa-li fa fa-times" id="lettercase"></i>Contains lettercase</li>
            <li class="red1-text"><i class="fa-li fa fa-times" id="uppercase"></i>Contains uppercase</li>
          </ul>
        </span>
      </a>
  </div>
  <div class="clearfix"></div>
  <div class="col l6 input-field">
    <?= Form::password('new_password_confirmation',array('id'=>'new_password_confirmation','class'=>'validate enter')) ?>
    <label for="new_password_confirmation">Confirm New Password</label>
  </div>
  <button name="submitButton" value="true" class="hide triggerButton"></button>

  <div class="col l12 right-align">
    <a href="#!" class=" submitButton btn btnB01">Save</a>
  </div>
  <input class="text_success" type="hidden" value="Change Password Successfully"/>
  {!! Form::close() !!}
</div>
@endsection

@section('changePasswordJs')
  {!! Html::script('assets/js/scriptChangePassword.js')!!}
@endsection
