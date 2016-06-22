@extends('layouts.app')

@section('content')

<?php
$page = "Set up your basic profile";
$step = "basic profile";
?>

<div class="row mb0 minHeight100vh valign-wrapper">
    <div class="container center-align valign getStartedContainer">
        @include('getting-started.getting-started-header')
        {!! Form::open(array('route' => 'getstarted.one','id'=>'getting-started-form')) !!}
        <!-- <img src="uploads/avatar/blank.jpg" class="circle" width="100">
        <a href="#!" class="lato-bold grey-text displayBlock underline">Set your profile picture</a> -->

        <div class="col s12">
          <div class="col l6 m6 s12 input-field">
            <?= Form::text('name','',array('id'=>'name','class'=>'validate enter')) ?>
              <label for="name">Full Name*</label>
          </div>
          <div class="col l6 m6 s12 input-field">
            <?= Form::text('company_name','',array('id'=>'company_name','class'=>'validate enter')) ?>
              <label for="company_name">Company Name*</label>
          </div>
            <div class="col l6 m6 s12 input-field">
              <?= Form::text('email','',array('id'=>'email','class'=>'validate enter')) ?>
                <label for="email">Email Address*</label>
            </div>
            <div class="col l6 m6 s12 input-field">
              <?= Form::text('phone','',array('id'=>'phone','class'=>'validate enter')) ?>
                <label for="phone">Phone</label>
            </div>
            <!-- // ====================== ADDRESS
            <div class="col s12 input-field">
                <textarea id="address" class="materialize-textarea"></textarea>
                <label for="address">Address</label>
            </div> -->
            <div class="col l6 m6 s12 input-field">
                <?= Form::password('password',array('id'=>'new_password','class'=>'validate enter')) ?>
                <label for="new_password">Password*</label>
                <span class="left-align" id="tooltipPass">
                  <ul class="fa-ul f12">
                    <li class="red1-text"><i class="fa-li fa fa-times" id="length"></i>At least 6 characters</li>
                    <li class="red1-text"><i class="fa-li fa fa-times" id="number"></i>Contains number</li>
                    <li class="red1-text"><i class="fa-li fa fa-times" id="lettercase"></i>Contains lowercase</li>
                    <li class="red1-text"><i class="fa-li fa fa-times" id="uppercase"></i>Contains uppercase</li>
                  </ul>
                </span>
            </div>
            <!-- <div class="col l6 m6 s12 input-field">
                <input type="text" id="language" disabled="disabled">
                <label for="language">Language</label>
            </div> -->
            <div class="col l6 m6 s12 input-field">
              <?= Form::password('password_confirmation',array('id'=>'password_confirmation','class'=>'validate enter')) ?>
              <label for="password_confirmation">Password Confirmation*</label>
            </div>
            <!-- <div class="col l6 m6 s12 input-field">
                <input type="text" id="country" disabled="disabled">
                <label for="country">Country</label>
            </div> -->
        </div>
        <input class="text_success" type="hidden" value="Step 1 is success. Moving to step 2..."/>
        @include('getting-started.next-button')
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('customjs')
{!! Html::script('assets/js/scriptGetStarted.js')!!}
{!! Html::script('assets/js/scriptChangePassword.js')!!}
@endsection
