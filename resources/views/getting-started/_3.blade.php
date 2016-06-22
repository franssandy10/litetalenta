@extends('layouts.app')

@section('content')

<?php
$page = "Tell us all departments you have in your company";
$step = "departments";
?>

<div class="row mb0 minHeight100vh valign-wrapper">
    <div class="container center-align valign getStartedContainer">

        @include('getting-started.getting-started-header')
        {!! Form::open(array('url' => 'get-started-3','id'=>'getting-started-form')) !!}

        <div class="col l10 offset-l1 s12 mb30">
            <div class="col l12 m12 s12 input-field mt30 displayNone">
                <select id="parent" class="mb0">
                    <option>-- Select Parent --</option>
                </select>
                <label for="parent">Parent</label>
            </div>
            <div class="col l10 m10 s12 input-field">
                <input type="text" id="department" class="mb0 autocompleteCustom1">
                <label for="department">Department Name</label>
                <p class="grey-text f11 left-align mt5">*press enter to add</p>
            </div>
            <div class="col s12 m2 l2 center-align">
                <a href="#!" id="addAutoComplete1" class="btn btnB01 clearfix mt30">Add</a>
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
@endsection
