@extends('layouts.app')
<?php
    $generalHeaderTitle1 = 'Employee Attendance';
    $generalHeaderButton = 'Back to Employee';
?>

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
        var dataTableFixedCol4 = $('#dataTableFixedCol4').dataTable({
            destroy: true,
            scrollX: true,
            "dom":'<"custom-toolbar left">flrti<"custom-pagination right">p',
            "pagingType": "full_numbers",
            "autoWidth": false,
            "aoColumns": [
                { "sWidth": "50px" },
                { "sWidth": "50px" },
                { "sWidth": "550px" },
                { "sWidth": "500px" },
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
            ],
            "oLanguage": {
              "sLengthMenu": "_MENU_",
              "sSearch": "_INPUT_",
              "sSearchPlaceholder": "Search...",
              "oPaginate": {
                "sNext": ">",
                "sPrevious": "<",
                "sFirst": "<<",
                "sLast": ">>"
              }
            },
            "columnDefs": [ {
                "targets"  : 'no-sort',
                "orderable": false,
            }]
        });

        new $.fn.dataTable.FixedColumns( dataTableFixedCol4, {
            leftColumns: 3
        });

        customTablePagination();
    })
    </script>
@endsection
@section('content')
@include('layouts.headers.general')
<div class="container mt30">
    <!--<div class="row mb30">
        <div class="col 12 m12 s12">
            <div class="col l4 m12 s12 pad-t-10 bgRed5 bRight bBottom h100 attendanceBox">
                <div class="col l8 m8 s8 input-field">
                    <input type="text" id="selectDate" class="datepicker">
                    <label for="selectDate" class="white-text">Select Date</label>
                </div>
                <div class="col l4 m4 s4">
                    <a href="#!" class="btn btnB01 mt20">submit</a>
                </div>
            </div>
            <a class="col l2 m4 s4 pad-t-10 pad-b-10 btnEmployeeIndex h100">
                <i class="talenta-transfer"></i>
                Import & Export
            </a>
            <a class="col l2 m4 s4 pad-t-10 pad-b-10 btnEmployeeIndex h100">
                <i class="talenta-tambah"></i>
                View<br>Report
            </a>
            <a class="col l2 m4 s4 pad-t-10 pad-b-10 btnEmployeeIndex h100">
                <i class="talenta-silang"></i>
                Delete<br>Attendance
            </a>
            <a class="col l2 m4 s4 pad-t-10 pad-b-10 btnEmployeeIndex last h100">
                <i class="talenta-kaca-pembesar"></i>
                Column<br>Search
            </a>
        </div>
    </div>-->
    <table class="bordered dataTable scroll" id="dataTableFixedCol4">
        <thead class="grey lighten-3">
            <tr>
                <!--<td class="no-sort">
                    <div class="col l12 input-field mtm20">
                        <input type="checkbox" class="filled-in check-all" id="check-all">
                        <label for="check-all"></label>
                    </div>
                </td>
                <td class="no-sort">
                    <a href="#!" class="bold tooltip2">
                        <i class="fa fa-info-circle"></i>
                        <span class="left-align f9">
                            Edit attendance, shift, overtime, or time off for every employee
                        </span>
                    </a>
                </td>-->
                <!--<td>Full Name</td>
                <td>Employee ID</td>-->
                <td>Date</td>
                <!--<td>Shift</td>
                <td>Schedule In</td>
                <td>Schedule Out</td>-->
                <td>Check In</td>
                <td>Check Out</td>
                <!--<td>End Date</td>-->
                <!--<td>Overtime</td>-->
                <!--<td>Attendance Code</td>
                <td>Timeoff Code</td>-->
            </tr>
        </thead>
        <tbody>
            @foreach($list as $value)
            <tr>
                <td>{{$value['date']}}</td>
                <td>{{$value['checked_in_at']}}</td>
                <td>{{$value['checked_out_at']}}</td>
                <!--<td>
                    <div class="col l12 input-field mtm20">
                        <input type="checkbox" class="filled-in" id="2">
                        <label for="2"></label>
                    </div>
                </td>
                <td>
                    <a href="#!" data-tooltip="Edit" class="red1-text"><i class="fa fa-pencil"></i></a>
                </td>
                <td><a href="{{ route('attendancedetail')}}" class="red1-text bold">Rizki Andrianto</a></td>-->
                
            </tr>
            @endforeach
            
            </tr>
        </tbody>
    </table>
</div>

@endsection
