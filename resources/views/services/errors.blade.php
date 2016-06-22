@extends('layouts.app')
@section('content')
<div class="h100vh w100p valign-wrapper errorPage">
  <div class="valign w100p">
    <div class="container">
      <div class="row">
        <div class="col l2 m2 offset-l3 offset-m3 s12">
          <img src="{{asset('assets/images/error-icon.png')}}" class="responsive-img">
        </div>
        <div class="col l6 m6 s12 left-align">
          @if ($errors)
            <p class="titleA01 white-text">Oops !</p>
            <p>
              Something went wrong, maybe because of: <br>
              <!-- Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem, tenetur iusto fuga hic perspiciatis ratione eum quasi ipsa autem, delectus exercitationem saepe asperiores libero! Facilis ipsam voluptatum odio ea velit nam illum repellendus enim reprehenderit atque dolorem, officiis ipsum ipsa animi optio commodi recusandae culpa dolor maxime eaque est architecto. -->
              {{$reason}}
            </p>
            <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
            </ul>
            <div class="row mt40">
              <div class="col l12 m12 s12">
                <a href="{{route('index')}}" class="btn btnB02">Back to Home</a>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
