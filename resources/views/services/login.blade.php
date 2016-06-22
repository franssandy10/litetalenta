<?php $headerLogin = "Welcome to Talenta" ?>
@extends('layouts.app')
@section('content')
<div class="loginBody">
  <div class="container valign-wrapper h100vh">
    <div class="valign w100p">
      @include('layouts.navbars.header-login')

      <div class="row">
        {!! Form::open(array('url' => 'login','class'=>'col s12','id'=>'register-form','autocomplete'=>'off')) !!}
          <div class="row">
            <div class="input-field col l5 s12 floatNone mlAuto mrAuto">
              <?= Form::email('email','',array('id'=>'email','class'=>'validate enter')) ?>
              <label for="email" class="white-text">Email</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col l5 s12 floatNone mlAuto mrAuto">
              <!-- <input placeholder="Placeholder" id="first_name" type="text" class="validate"> -->
              <?= Form::password('password',array('id'=>'password','class'=>'validate enter')) ?>
              <label for="password" class="white-text">Password</label>
            </div>
          </div>
        <input class="text_success" type="hidden" value="Login Successfull"/>
        {!! Form::close() !!}
        <a class="btn btnB01 white-text bWhite positionRelative" id="submitButton">login</a>
      </div>
      @include('layouts.footers.footer-login')
    </div><!-- Valign -->
  </div>
</div>

@endsection
@section('customjs')
<script>
$(document).ready(function(){
  $("#submitButton").click(function(){
    $form=$(this).parents('.container').find('form');
    validateForm($form);
  });
});
</script>
@endsection
