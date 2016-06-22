<?php
$status = "Approved";
$headerLogin = "Time off Request Approval" ;
?>
@extends('layouts.app')
@section('content')
<div class="loginBody">
  <div class="container valign-wrapper h100vh">
    <div class="valign w100p">
      @include('layouts.navbars.header-login')

      <div class="row">
        <p class="white-text">You have {{$status}} time off request from <strong>Rizki Andrianto</strong> from: <br>
        <strong>Thu, 19 May</strong> until <strong>Wed, 5 Jun</strong>
        <br><br>
        Reason:<br>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. At voluptatum nesciunt aliquam minus eaque culpa accusantium dolorem impedit hic necessitatibus.
        </p>

        <a href="{!! route('login')!!}" class="btn btnB01 white-text bWhite positionRelative mt30" id="submitButton">login</a>
      </div>
      @include('layouts.footers.footer-login')
    </div><!-- Valign -->
  </div>
</div>

@endsection
@section('customjs')
@endsection
