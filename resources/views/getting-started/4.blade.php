@extends('layouts.app')

@section('content')

<?php
$step = $page = "configure Payroll";
?>

<div class="row mb0 h100vh valign-wrapper">
    <div class="container center-align valign getStartedContainer">

        @include('getting-started.getting-started-header')
        {!! Form::open(array('url' => 'get-started-4','id'=>'getting-started-form')) !!}
          <div class="col s12">
              <div class="col l6 m6 s12 input-field">
                <?= Form::text('tax_person_name','',array('id'=>'tax_person_name','class'=>'validate enter')) ?>
                <label for="tax_person_name">Tax Person Name*</label>
              </div>
              <div class="col l6 m6 s12 input-field">
                <?= Form::text('tax_person_npwp','',array('id'=>'tax_person_npwp','class'=>'validate enter npwp_format')) ?>
                <label for="tax_person_npwp">Tax Person NPWP*</label>
              </div>
              <div class="col l6 m6 s12 input-field">
                <?= Form::text('company_npwp','',array('id'=>'company_npwp','class'=>'validate enter npwp_format')) ?>
                <label for="company_npwp">Company NPWP*</label>
              </div>
              <div class="col l6 m6 s12 input-field">
                <?= Form::text('npwp_date','',array('id'=>'npwp_date','class'=>'validate enter datepicker')) ?>
                <label for="npwp_date">NPWP Date*</label>
              </div>
              <div class="col l6 m6 s12 input-field">
                <?= Form::text('company_bpjstk','',array('id'=>'company_bpjstk','class'=>'validate enter')) ?>
                <label for="company_bpjstk">BPJS Ketenagakerjaan*</label>
              </div>
              <div class="col l6 m6 s12 input-field">
                <?= Form::select('company_jkk', BaseService::getDataJkk(),'',['id'=>'company_jkk','class'=>'validate']); ?>
                  <label for="company_jkk">JKK*</label>
              </div>
          </div>
          <input class="text_success" type="hidden" value="Congrats ! You're now registered"/>
          @include('getting-started.next-button')
        {!! Form::close() !!}
    </div>


</div>

@endsection
@section('customjs')
{!! Html::script('assets/js/scriptGetStarted.js')!!}
@endsection
