<?php $headerLogin = "Reset Password" ?>
@extends('layouts.app')
@section('content')
<div class="loginBody">
  <div class="container valign-wrapper h100vh">
    <div class="valign w100p">
      @include('layouts.navbars.header-login')
      <div class="clearfix"></div>
      <div class="row">
        {!! Form::open(array('url' => 'reset-password/'.$id,'class'=>'col s12','id'=>'register-form','autocomplete'=>'off')) !!}
        <div class="row">
            <div class="input-field col l5 s12 floatNone mlAuto mrAuto">
              <!-- <input placeholder="Placeholder" id="first_name" type="text" class="validate"> -->
              <?= Form::password('new_password',array('id'=>'new_password','class'=>'validate enter')) ?>
              <label for="new_password" class="white-text">New Password</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col l5 s12 floatNone mlAuto mrAuto">
              <?= Form::password('new_password_confirmation',array('id'=>'new_password_confirmation','class'=>'validate enter')) ?>
              <label for="new_password_confirmation"  class="white-text">Password Confirmation</label>
            </div>
        </div>
        <input class="text_success" type="hidden" value="Reset Password is Successfull">

        <a class="btn btnB01 white-text bWhite positionRelative mr5 submitButton">submit</a>
        {!! Form::close() !!}
      </div>
      @include('layouts.footers.footer-login')
    </div><!-- Valign -->
  </div>
</div>

@endsection
