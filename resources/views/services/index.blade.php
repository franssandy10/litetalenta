@extends('layouts.app')

@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.navbar')
 @endsection
@section('content')


<div class="row mtm65 section1">
    <div class="col l12 m12 s12 valign-wrapper h100vh">
        <div class="col l6 offset-l3 s12 white-text center-align ">
            <h1 class="valign lato-bold f46">The best way to manage your current and future talents.</h1>
            <p class="lato-light f18 mt0">This is the best way to manage your talents when you just started your company or if you have a small team to manage yet you want to move from confusing spreadsheets.</p>
        </div>
    </div>
</div>

<!-- Section 2 -->
<div class="row white pad-t-50 pad-b-50 mb0 mt0">
    <div class="container">
        <div class="col l4 m4 s12 pad-l-40 pad-r-40">
            <img src="assets/images/imac.png" width="100%">
        </div>
        <div class="col l8 m8 s12 pad-l-40 pad-r-40">
            <p class="lato-light red1-text f30 bold mb10">Introducing Talenta Lite</p>
            <p class="mt0">Compared to the full scale Talenta, we have rebuilt the software from ground up to create Talenta Lite - especially for you business owners that doesn’t have complex payroll and just need a really great software, simple, yet affordable to manage your employee.</p>
            <a href="#!" class="btn btnB01 bRed ls2 red1-text mt20">try now</a>
        </div>
    </div>
</div><!-- Section 2 -->

<!-- Section 3 -->
<div class="row white pad-b-20 mb0 mt0">
    <div class="container">
        <p class="lato-bold f30 col l12 m12 s12 mb0">Awesome Features</p>
        <div class="col l6 m6 s12">
            <p class="grey-text f56 mb0 mt10">01</p>
            <p class="ls2 red1-text mt0 text-uppercase lato-black f14">employee database</p>
            <p class="mt0">No more tracking your employee database on a spreadsheet and sharing it amongst your team. Now with centralized database, you can access it anywhere anytime.</p>
        </div>
        <div class="col l6 m6 s12">
            <p class="grey-text f56 mb0 mt10">02</p>
            <p class="ls2 red1-text mt0 text-uppercase lato-black f14">track your attendance</p>
            <p class="mt0">We have built a very simple clock in and clock out method to track your team’s attendance. No more paying for fingerprint machine way too early in your company’s life.</p>
        </div>
        <div class="col l6 m6 s12">
            <p class="grey-text f56 mb0 mt10">03</p>
            <p class="ls2 red1-text mt0 text-uppercase lato-black f14">time off tracking</p>
            <p class="mt0">Transparency and Easeness are the two words that describe our time off tracking. We have prepared a default time off policies that are adopted from Indonesia policies, but other than that, you can customize your own policy.</p>
        </div>
        <div class="col l6 m6 s12">
            <p class="grey-text f56 mb0 mt10">04</p>
            <p class="ls2 red1-text mt0 text-uppercase lato-black f14">simple payroll</p>
            <p class="mt0">No more paying millions for an outsourced payroll and payroll tax counting. With Talenta, you can opt to count your payroll in our system with a simple flow and accurate reporting.</p>
        </div>
    </div>
</div><!-- Section 3 -->

<!-- Section 4 -->
<div class="row white pad-b-20 mb0 mt0">
    <div class="container">
        <p class="lato-bold f30 col l12 m12 s12 mb0">Comparison</p>
        <div class="col l2 m2 hide-on-small-only lato-light grey-text mt10 pad-t-20 pad-b-20">
            <p class="bold mb15">FEATURE</p>
            <p class="pad-t-5 pad-b-5 mb10">Attendance</p>
            <p class="pad-t-5 pad-b-5 mb10">Payroll</p>
            <p class="pad-t-5 pad-b-5 mb10">Support</p>
            <p class="pad-t-5 pad-b-5 mb10">Payroll</p>
        </div>
        <div class="col l4 m4 s12 bgRed2 mr30 white-text mt10 pad-t-20 pad-b-20">
            <p class="lato-black ls2 mb15">TALENTA LITE</p>
            <p class="pad-t-5 pad-b-5 bgRed1 pad-l-7 pad-r-7 mlm17 displayTable mb10">Built-in System</p>
            <p class="pad-t-5 pad-b-5 bgRed1 pad-l-7 pad-r-7 mlm17 displayTable mb10">Simple and Default System <small class="f9">(optional)</small></p>
            <p class="pad-t-5 pad-b-5 bgRed1 pad-l-7 pad-r-7 mlm17 displayTable mb10">Support e-mail</p>
            <p class="pad-t-5 pad-b-5 bgRed1 pad-l-7 pad-r-7 mlm17 displayTable mb10">Free*</p>
        </div>
        <div class="col l4 m4 s12 bgRed2 white-text mt10 pad-t-20 pad-b-20">
            <p class="lato-black ls2 mb15">TALENTA PRO</p>
            <p class="pad-t-5 pad-b-5 bgRed1 pad-l-7 pad-r-7 mlm17 displayTable mb10">Fingerprint Machine</p>
            <p class="pad-t-5 pad-b-5 bgRed1 pad-l-7 pad-r-7 mlm17 displayTable mb10">Can handle all payroll cases</p>
            <p class="pad-t-5 pad-b-5 bgRed1 pad-l-7 pad-r-7 mlm17 displayTable mb10">E-mail, phone-call, and live support</p>
            <p class="pad-t-5 pad-b-5 bgRed1 pad-l-7 pad-r-7 mlm17 displayTable mb10">IDR 10,000 / employee / month</p>
        </div>

        <div class="col l12 m12 s12 mt30">
            <p>If you have just started your company and or you want to keep the team lean yet you want to move in from spreadsheet, Talenta Lite is for you! If you are a growing company, in need of a more customized HR software, Talenta Pro (talenta.co) is for you. Choose whichever you like and we are ready to help you move from old clunky software to a new and awesome payroll system.</p>
            <p class="lato-bold f9">*FREE will be limited for the first 6 months, after that we’ll apply a flat rate of $10/month</p>
        </div>
    </div>
</div><!-- Section 4 -->
@endsection
@section('footer')
@include('layouts.footers.footer')
@endsection