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
        {!! Form::open(array('url' => 'get-started-2','id'=>'getting-started-form')) !!}
          <div class="col l6 offset-l3 s12">
              <div class="col l5 offset-l1 m6 s12 input-field">
                <?= Form::input('number','holiday',null,array('id'=>'holiday','class'=>'center-align')) ?>
                <label for="holiday" class="lato-black text-uppercase f13 ls2 center-align black-text left0 right0">HOLIDAY</label>
              </div>
              <div class="col l5 m6 s12 input-field">
                <?= Form::input('number','sick',null,array('id'=>'sick','class'=>'center-align')) ?>
                  <label for="sick" class="lato-black text-uppercase f13 ls2 center-align black-text left0 right0">sick day</label>
              </div>
          </div>
          <input class="text_success" type="hidden" value="Step 2 is success. Moving to step 3..."/>
          @include('getting-started.next-button')
        {!! Form::close() !!}
    </div>


</div>

@endsection
@section('customjs')
{!! Html::script('assets/js/scriptGetStarted.js')!!}
<script type="text/javascript">
  $(document).ready(function(){
    $('#holiday, #sick').keyup(function(){
      console.log($(this).val())
      if ($('#holiday').val() == '' && $('#sick').val() == '') {
        $('#submitButton').text('Skip')
      }
      else {
        $('#submitButton').text('Next') 
      }
    })
  })
</script>
@endsection
