@extends('layouts.app')

<?php
    $generalHeaderTitle1 = 'Rizki\'s Attendance';
    $generalHeaderTitle2 = 'Absence : 22 | Late : 0 | Early Out : 0';
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

@endsection
@section('content')
@include('layouts.headers.general')
<div class="container mt30">
    <div class="row mb30">
        <div class="col 12 m12 s12">
            <div class="col l6 m12 s12 pad-t-10 bgRed5 bRight bBottom h100 attendanceBox">
                <div class="col l4 m4 s4 input-field">
                    <select>
                        <option value="">Januari</option>
                        <option value="">Febuari</option>
                        <option value="">Maret</option>
                    </select>
                    <label for="selectMonth" class="white-text">Month</label>
                </div>
                <div class="col l4 m4 s4 input-field">
                    <select>
                        <option value="">1992</option>
                        <option value="">2005</option>
                        <option value="">2015</option>
                    </select>
                    <label for="selectMonth" class="white-text">Year</label>
                </div>
                <div class="col l4 m4 s4">
                    <a href="#!" class="btn btnB01 mt20">submit</a>
                </div>
            </div>
            <a class="col l2 m4 s6 pad-t-10 pad-b-10 btnEmployeeIndex h100">
                <i class="talenta-transfer"></i>
                Import & Export
            </a>
            <a class="col l2 m4 s6 pad-t-10 pad-b-10 btnEmployeeIndex h100">
                <i class="talenta-silang"></i>
                Delete<br>Attendance
            </a>
            <a class="col l2 m4 s4 pad-t-10 pad-b-10 btnEmployeeIndex last h100">
                <i class="talenta-kaca-pembesar"></i>
                Column<br>Search
            </a>
        </div>
    </div>
    <table class="bordered dataTable scroll">
        <thead class="grey lighten-3">
            <tr>
                <td class="no-sort">
                    <div class="col l12 input-field mtm20">
                        <input type="checkbox" class="filled-in check-all" id="check-all">
                        <label for="check-all"></label>
                    </div>
                </td>
                <td class="no-sort">
                    <a href="#!" class="bold tooltip2 tooltip2-right">
                        <i class="fa fa-info-circle"></i>
                        <span class="left-align f9">
                            Edit attendance, shift, overtime, or time off for every employee
                        </span>
                    </a>
                </td>
                <td>Full Name</td>
                <td>Employee ID</td>
                <td>Date</td>
                <td>Shift</td>
                <td>Schedule In</td>
                <td>Schedule Out</td>
                <td>Check In</td>
                <td>Check Out</td>
                <td>End Date</td>
                <td>Overtime</td>
                <td>Attendance Code</td>
                <td>Timeoff Code</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="col l12 input-field mtm20">
                        <input type="checkbox" class="filled-in" id="2">
                        <label for="2"></label>
                    </div>
                </td>
                <td>
                    <a href="#!" data-tooltip="Edit" class="red1-text"><i class="fa fa-pencil"></i></a>
                </td>
                <td><a href="#!" class="red1-text bold">Rizki Andrianto</a></td>
                <td>TDI-008</td>
                <td>2016-01-07</td>
                <td>dayoff</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
            </tr>
            <tr>
                <td>
                    <div class="col l12 input-field mtm20">
                        <input type="checkbox" class="filled-in" id="2">
                        <label for="2"></label>
                    </div>
                </td>
                <td>
                    <a href="#!" data-tooltip="Edit" class="red1-text"><i class="fa fa-pencil"></i></a>
                </td>
                <td><a href="#!" class="red1-text bold">Rizki Andrianto</a></td>
                <td>TDI-008</td>
                <td>2016-01-07</td>
                <td>dayoff</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
            </tr>
            <tr>
                <td>
                    <div class="col l12 input-field mtm20">
                        <input type="checkbox" class="filled-in" id="2">
                        <label for="2"></label>
                    </div>
                </td>
                <td>
                    <a href="#!" data-tooltip="Edit" class="red1-text"><i class="fa fa-pencil"></i></a>
                </td>
                <td><a href="#!" class="red1-text bold">Rizki Andrianto</a></td>
                <td>TDI-008</td>
                <td>2016-01-07</td>
                <td>dayoff</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
            </tr>
            <tr>
                <td>
                    <div class="col l12 input-field mtm20">
                        <input type="checkbox" class="filled-in" id="2">
                        <label for="2"></label>
                    </div>
                </td>
                <td>
                    <a href="#!" data-tooltip="Edit" class="red1-text"><i class="fa fa-pencil"></i></a>
                </td>
                <td><a href="#!" class="red1-text bold">Rizki Andrianto</a></td>
                <td>TDI-008</td>
                <td>2016-01-07</td>
                <td>dayoff</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
            </tr>
            <tr>
                <td>
                    <div class="col l12 input-field mtm20">
                        <input type="checkbox" class="filled-in" id="2">
                        <label for="2"></label>
                    </div>
                </td>
                <td>
                    <a href="#!" data-tooltip="Edit" class="red1-text"><i class="fa fa-pencil"></i></a>
                </td>
                <td><a href="#!" class="red1-text bold">Rizki Andrianto</a></td>
                <td>TDI-008</td>
                <td>2016-01-07</td>
                <td>dayoff</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
            </tr>
            <tr>
                <td>
                    <div class="col l12 input-field mtm20">
                        <input type="checkbox" class="filled-in" id="2">
                        <label for="2"></label>
                    </div>
                </td>
                <td>
                    <a href="#!" data-tooltip="Edit" class="red1-text"><i class="fa fa-pencil"></i></a>
                </td>
                <td><a href="#!" class="red1-text bold">Rizki Andrianto</a></td>
                <td>TDI-008</td>
                <td>2016-01-07</td>
                <td>dayoff</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
