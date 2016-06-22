@extends('layouts.app')

@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
@endsection

@section('customCss')
	{!! Html::style('assets/css/style-setting.css')!!}
@endsection

@section('content')
	@include('layouts.navbars.header-setting')
	<div class="container">
		<div class="row h-tabRow">
			<div class="col l12 white pad-l-n h-tabRow">
				<div class="settingDiv">
					<div class="row">
						@if (Session::has('register_success'))
						<div class="alert alert-danger">
							<p>
								{!! Session::get('register_success') !!}
							</p>
						</div>
						@endif
						<p class="titleB01">Recommendation</p>
						<hr class="mb40">
						<p>If a friend’s company signs up, they get a great piece of software. You will also get discount as big as their first month bill and a bit of good karma. A true win-win, then.</p>

						<p class="titleB01 mt40">Enter your friend's detail</p>
						{!! Form::open(array('url' => 'setting/sendemail','class'=>'col s12','id'=>'register-form','autocomplete'=>'off')) !!}

							<div class="col l6 input-field">
								{!! Form::text('name', null, array('class' => 'validate enter', 'id' => 'name')) !!}
								{!! Form::label('name', 'Name: ') !!}
							</div>
							<div class="col l6 input-field">
								{!! Form::text('email', null, array('class' => 'validate enter', 'id' => 'email')) !!}
								{!! Form::label('email', 'Email: ') !!}
							</div>
							<input class="text_success" type="hidden" value="Email Has Been Sent"/>

							<input type="submit" name="submitButton" value="true" class="hide triggerButton">

					        {!! Form::close() !!}
					    <div class="col l12 mt40">
					        <a class="btn btnB01" id="submitButton">Recommend</a>
					    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('customjs')
<script>
$(document).ready(function(){
  $("#submitButton").click(function(){
    $form=$(this).parents('.container').find('form');
    $form.submit();
    validateForm($form);
  });
});
</script>
@endsection
