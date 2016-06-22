@extends('layouts.app')

@section('content')

<?php
$step = $page = "Payroll Feature";
?>

<div class="row mb0 minHeight100vh valign-wrapper">
    <div class="container center-align valign getStartedContainer">

        @include('getting-started.getting-started-header')

        <p class="lato-black f14">Do you want to use our payroll feature?</p>
        {!! Form::open(array('url' => 'get-started-3','id'=>'getting-started-form')) !!}
        <div class="col l10 offset-l1 s12 mb40 getStartedPayrollChoice">
            <div class="col l6 m6 s6 input-field yesNo">
              <?= Form::radio('payroll_flag','yes',true, ['id' => 'yes','class'=>'choices']) ?>

                <label for="yes" class="lato-black text-uppercase f13 ls2 center-align black-text pad-none left0">
                    <img src="assets/images/yes.png" width="50" class="mt10 displayBlock mlAuto mrAuto">
                    yes, i need it
                </label>
            </div>
            <div class="col l6 m6 s6 input-field yesNo">
              <?= Form::radio('payroll_flag','no',false, ['id' => 'no','class'=>'choices']) ?>
                <label for="no" class="lato-black text-uppercase f13 ls2 center-align black-text pad-none left0">
                    <img src="assets/images/no.png" width="50" class="mt10 displayBlock mlAuto mrAuto">
                    no, thanks
                </label>
            </div>
        </div>
        <input class="text_success" type="hidden" value="Step 3 is success. Moving to step 4..."/>
        @include('getting-started.next-button')
        {!! Form::close() !!}
    </div>
</div>
@endsection
@section('customjs')
{!! Html::script('assets/js/scriptGetStarted.js')!!}
<script>
$(document).ready(function(){
  $(".choices").change(function(){
    var val = $(this).val();
    if(val==='yes'){
      $(".text_success").val('Step 3 is success. Moving to step 4...');
    }
    else{
      $(".text_success").val('All Step is finish');
    }
    payrollChecker(val);
  });

  function payrollChecker(val){
    $.when($('.progress-indicator').slideUp(300)).done(function (v1) {
        $.when(cekVal(val)).done(function () {
            $('.progress-indicator').slideDown(300);
            var stepLength = $('.progress-indicator li:visible').length;
            $('span#countStep').text(stepLength);
        });
    });
  }

  function cekVal(val){
    if (val==='no') {
        var lastList = $('.progress-indicator li:last').hide();
    }
    else {
        var lastList = $('.progress-indicator li:last').show();
    }
  }
})
</script>
@endsection
