<?php $headerLogin = "Forgot Password?" ?>
@extends('layouts.app')
@section('content')
<div class="loginBody">
  <div class="container valign-wrapper h100vh">
    <div class="valign w100p">
      @include('layouts.navbars.header-login')
      <div class="clearfix"></div>
      <p class="white-text mt20 w80p mlAuto mrAuto">No problem, We'll send you a link to reset your password. <br><span class="hide-on-med-and-down">If the email doesn't come at the moment, please check your spam folder</span></p>
      <div class="row">
        {!! Form::open(array('route' => 'forgotpassword','class'=>'col s12','autocomplete'=>'off')) !!}
        <div class="row">
          <div class="input-field col l5 s12 floatNone mlAuto mrAuto">
            <?= Form::email('email','',array('id'=>'email','class'=>'validate enter')) ?>
            <label for="email" class="white-text">Email</label>
          </div>
        </div>
        <div class="row center-align">
          {!! app('captcha')->display(); !!}
        </div>
        <input class="text_success" type="hidden" value="Sent email to your email for reset password"/>
        <a class="btn btnB01 white-text bWhite positionRelative mr5 submitButton">submit</a>
        <a href="{{route('login')}}" class="btn btnB01 white-text bWhite positionRelative">cancel</a>
          {!! Form::close() !!}
      </div>
      @include('layouts.footers.footer-login')
    </div><!-- Valign -->
  </div>
</div>

@endsection

@section('customCss')
  <style type="text/css">
    .g-recaptcha div {
      margin: 0 auto;
    }

    .rc-anchor-alert {
      display: none;
    }
  </style>
@endsection
@section('customjs')
<script>
function validateForm($form){
	var button = $form.find('.btnB01');
	button.addClass('disabled');
	$.ajax({
		url:$form.attr('action'),
		method:"POST",
		dataType:'JSON',
		data:$form.serializeArray(),
		success:function(data){
			if(data.status=='success'){
					Materialize.toast($form.find('.text_success').val()+'<i class="fa fa-check ml25"></i>', 3000,'teal',function(){
						if(data.url){
							window.location.href = data.url;
						}
						button.removeClass('disabled');
					});
			}
			else{
        grecaptcha.reset();
				button.removeClass('disabled')
				$.each(data,function(x,y){
						$("#"+x).addClass('invalid');
						console.log(y);
						$.each(y,function(a,b){
							Materialize.toast(b+' <i class="fa fa-times ml25"></i>', 3000,'red accent-4');
						});

				})
			}
		},
		error:function(data){
			console.log(data);
		}
	});
}
</script>
@endsection
