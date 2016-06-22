@extends('layouts.app')

@section('content')

<?php
$step = $page = "Payroll Feature";
?>

<div class="row mb0 minHeight100vh valign-wrapper">
    <div class="container center-align valign getStartedContainer">

        @include('getting-started.getting-started-header')

        <p class="lato-black f14">Do you want to use our payroll feature?</p>
        {!! Form::open(array('url' => 'get-started-6','id'=>'getting-started-form')) !!}
        <div class="col l6 offset-l3 s12 mb40">
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
        <input class="text_success" type="hidden" value="Step 6 is success. Moving to step 7..."/>
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
      $(".text_success").val('Step 6 is success. Move to step 7');
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
        });
    });
  }

  function cekVal(val){
    if (val==='no') {
        var lastList = $('.progress-indicator li:last').hide(); 
        $('span#countStep').text('6');
    }
    else {
        var lastList = $('.progress-indicator li:last').show();
        $('span#countStep').text('7');
    }
  }
})
</script>
@endsection
