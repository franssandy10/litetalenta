@extends('layouts.app')

@section('content')

<?php
$page = "Time Off settings";
$step = 'time off'
?>

<div class="row mb0 minHeight100vh valign-wrapper">
    <div class="container center-align valign getStartedContainer">

        @include('getting-started.getting-started-header')

        <p class="lato-black f14 mb15">How many days of time off you give to your employees annually?</p>
        {!! Form::open(array('url' => 'get-started-5','id'=>'getting-started-form')) !!}
          <div class="col l4 offset-l4 s12">
              <div class="col l5 offset-l1 m6 s12 input-field">
                <?= Form::input('number','holiday','12',array('id'=>'holiday','class'=>'center-align')) ?>
                <label for="holiday" class="lato-black text-uppercase f13 ls2 center-align black-text left0 right0">HOLIDAY</label>
              </div>
              <div class="col l5 m6 s12 input-field">
                <?= Form::input('number','sick','12',array('id'=>'sick','class'=>'center-align')) ?>
                  <label for="sick" class="lato-black text-uppercase f13 ls2 center-align black-text left0 right0">sick day</label>
              </div>
          </div>
          <input class="text_success" type="hidden" value="Step 5 is success. Moving to step 6..."/>
          @include('getting-started.next-button')
        {!! Form::close() !!}
    </div>


</div>

@endsection
@section('customjs')
{!! Html::script('assets/js/scriptGetStarted.js')!!}
@endsection
