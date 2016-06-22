@extends('layouts.app')

@section('content')

<?php
$page = "set your Company Profile";
$step = "company profile";
?>

<div class="row mb0 minHeight100vh valign-wrapper">
    <div class="container center-align valign getStartedContainer">

        @include('getting-started.getting-started-header')

        {!! Form::open(array('url' => 'get-started-2','id'=>'getting-started-form')) !!}
          <div class="col l10 offset-l1 s12">
              <div class="col l6 m6 s12 input-field">
                <?= Form::text('name',null,array('id'=>'name','class'=>'validate enter')) ?>
                  <label for="name">Company Name</label>
              </div>
              <div class="col l6 m6 s12 input-field">
                <?= Form::text('email',null,array('id'=>'email','class'=>'validate enter')) ?>
                  <label for="email">Email</label>
              </div>
              <div class="col l12 s12 input-field">
                <?= Form::textarea('address',null,array('id'=>'address','class'=>'validate enter materialize-textarea')) ?>
                  <label for="address">Address</label>
              </div>
              <div class="col l6 s12 input-field">
                <?= Form::select('province_id_fk', UserService::getProvince(),null,['id'=>'province_id_fk','class'=>'validate enter']); ?>
                  <label for="province_id_fk">Province</label>
              </div>
              <div class="col l6 s12 input-field">
                <?= Form::text('city','',['id'=>'city','class'=>'validate enter']); ?>
                  <label for="city">City</label>
              </div>
              <div class="col l6 m6 s12 input-field">
                <?= Form::text('postcode','',array('id'=>'postcode','class'=>'validate enter')) ?>
                  <label for="postcode">Postcode</label>
              </div>
              <div class="col l6 m6 s12 input-field">
                <?= Form::text('phone','',array('id'=>'phone','class'=>'validate enter')) ?>
                  <label for="phone">Phone</label>
              </div>
          </div>
          <input class="text_success" type="hidden" value="Step 2 is success. Moving to step 3..."/>
          @include('getting-started.next-button')       
        {!! Form::close() !!}
    </div>
</div>

@endsection
@section('url-ajax')
<input id="url_get_city" type="hidden" value="{{url('services/get-city')}}" />
@endsection('url-ajax')
@section('customjs')
{!! Html::script('assets/js/scriptGetStarted.js')!!}
@endsection
