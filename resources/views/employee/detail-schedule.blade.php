@extends('layouts.app')
@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
 @endsection

@section('content')
@include('layouts.headers.general')

<div class="container mt30">
    <table class="bordered">
        <thead class="grey lighten-3">
            <tr>
                <td class="no-sort" width="80">Photo</td>
                <td>Full Name</td>
                <td>Employee ID</td>
                <td>Schedule</td>
                <td>Effective Date</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="50"><img class="circle" width="50" src="{{asset(config('param.url_uploads').'blank.jpg')}}"/></td>
                <td>Rizki Andrianto</td>
                <td>156486</td>
                <td>Seperti biasa</td>
                <td>15 January, 2009</td>
                <td>
                    <a href="#!" class="red1-text bold" data-tooltip="Remove"><i class="fa fa-times"></i></a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
