@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    {!! Form::open(array('url' => 'register','class'=>'col s12','id'=>'login-form')) !!}
    <div class="row">
       <div class="input-field col s4">
         <!-- <input placeholder="Placeholder" id="first_name" type="text" class="validate"> -->
         <?= Form::text('name','',array('id'=>'name','class'=>'validate')) ?>
         <label for="name">Full Name</label>
       </div>
       <div class="input-field col s4">
         <?= Form::email('email','',array('id'=>'email','class'=>'validate')) ?>
         <label for="email">Email</label>
       </div>
       <div class="input-field col s4">
         <?= Form::text('company_name','',array('id'=>'company_name','class'=>'validate')) ?>
         <label for="company_name">Company Name</label>
       </div>
     </div>
     <div class="row">
        <div class="input-field col s6">
          <!-- <input placeholder="Placeholder" id="first_name" type="text" class="validate"> -->
          <?= Form::password('password',array('id'=>'password','class'=>'validate')) ?>
          <label for="password">Password</label>
        </div>
        <div class="input-field col s6">
          <?= Form::password('password_confirmation',array('id'=>'password_confirmation','class'=>'validate')) ?>
          <label for="password_confirmation">Password Confirmation</label>
        </div>
    </div>
    <input type="submit" name="submitButton" id="triggerButton" value="true" class="hide">
    <div class="row">
      <a class="btn waves-effect waves-light" id="submitButton" name="submitButton">Submit
        <i class="material-icons right">send</i>
      </a>
    </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection
@section('customjs')
  
  <!-- This is the position navbar. -->
  {!! Html::script('assets/js/scriptRegister.js')!!}
<script>

$(document).ready(function(){
  $("#submitButton").click(function(){
    $form=$(this).parents('.container').find('form');
    validateForm($form);
  });

$('#login-form').on('submit', function(e){
    e.preventDefault();
  })
});

</script>
 @endsection
