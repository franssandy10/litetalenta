@extends('layouts.app')
@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
 @endsection

@section('customCss')
    {!! Html::style('assets/plugins/dataTable/datatables.min.css')!!}
@endsection
@section('customjs')
    {!! Html::script('assets/plugins/dataTable/datatables.min.js')!!}
    {!! Html::script('assets/js/scriptDataTable.js')!!}

    <script type="text/javascript">
    $(document).ready(function(){
        $('custom').detach().appendTo('.custom-toolbar')
    })
    </script>

@endsection

@section('content')
@include('layouts.headers.general')

<custom>
    <a href="#!" class="btn btnB01 mt10 mr5">Add to Schedule</a>
    <a href="#!" class="btn btnB01 mt10 mr5">Import</a>
    <a href="#!" class="btn btnB01 mt10 mr5">Export</a>
</custom>
<div class="container mt30">
    <table class="bordered dataTable">
        <thead class="grey lighten-3">
            <tr>
                <td width="20" class="no-sort">
                    <div class="col l12 input-field mtm20">
                        <input type="checkbox" class="filled-in check-all" id="check-all">
                        <label for="check-all"></label>
                    </div>
                </td>
                <td class="no-sort">Photo</td>
                <td>Full Name</td>
                <td>Employee ID</td>
                <td>Job Title</td>
                <td>Hire Date</td>
                <td>Current Schedule</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="20">
                    <div class="col l12 input-field mtm20">
                        <input type="checkbox" class="filled-in" id="2">
                        <label for="2"></label>
                    </div>
                </td>
                <td width="50"><img class="circle" width="50" src="{{asset(config('param.url_uploads').'blank.jpg')}}"/></td>
                <td><a href="#!" class="red1-text bold">Rizki Andrianto</a></td>
                <td>156486</td>
                <td>Front-end Developer</td>
                <td>15 January, 2009</td>
                <td>Seperti Biasa</td>
            </tr>
            <tr>
                <td width="20">
                    <div class="col l12 input-field mtm20">
                        <input type="checkbox" class="filled-in" id="3">
                        <label for="3"></label>
                    </div>
                </td>
                <td width="50"><img class="circle" width="50" src="{{asset(config('param.url_uploads').'blank.jpg')}}"/></td>
                <td><a href="#!" class="red1-text bold">Rizki Andrianto</a></td>
                <td>156486</td>
                <td>Front-end Developer</td>
                <td>15 January, 2009</td>
                <td>Seperti Biasa</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
