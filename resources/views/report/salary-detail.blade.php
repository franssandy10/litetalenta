@extends('layouts.app')

@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
@endsection

@section('customCss')
	{!! Html::style('assets/plugins/dataTable/datatables.min.css')!!}
  {!! Html::style('assets/css/styleTablePayroll.css')!!}

  <style type="text/css">
  table {
    width: auto;
    min-width: 100%;
  }

  table tr td,
  table tr th {
    border: 1px solid #cacaca;
    padding: 5px;
  }
  </style>
@endsection

@section('customjs')
  <!--{!! Html::script('assets/plugins/tablesorter/jquery.tablesorter.js')!!}-->
  <script type="text/javascript" src="http://mottie.github.io/tablesorter/dist/js/jquery.tablesorter.min.js"></script>
  <script type="text/javascript" src="https://mottie.github.io/tablesorter/js/jquery.tablesorter.widgets.js"></script>
  <script type="text/javascript">

    $(document).ready(function(){
      // loading();
      if ($('#salaryDetailTable').height() < 370) {
        $('#salaryDetailTable').parent().removeClass('h370');
      }
    });

    countRow = 0;


    socket.on("salary", function (data) {
      nodeTable(data);
      $('#searchLive').keyup();
      $(".uiGridContent table thead").show();
      $(".table").tablesorter();
    });
  </script>
@endsection



@section('content')
  @include('layouts.headers.general')

	<div class="container mt30 dataTablePoint">
    <div class="row">
      <div class="col l6 m6 s12">
        <a href="/report/salary-detail/pdf/{{ $month_process}}/{{ $year_process }}" class="btn btnB01 mt10 mr5">Download PDF</a>
        <a href="#!" class="btn btnB01 mt10">Download XLS</a>
      </div>
      <div class="col l3 m3 s12 input-field right">
        <input type="text" class="search mb0" placeholder="Search" id="searchLive">
      </div>
      <!-- <div class="col l2 m3 s12 input-field right">
        <select id="columnselect">
          <option value="all">All Column</option>
          <option value="0">Employee ID</option>
          <option value="1">Full Name</option>
          <option value="2">Job Title</option>
          <option value="3">Basic Salary</option>
          <option value="4">Total Allowance</option>
          <option value="5">Total Deduction</option>
        </select>
        <label for="columnSelect"></label>
      </div> -->
    </div>
    <div class="row">
      <div class="col s12 positionRelative">
        <!-- <div class="w100p uiGridHeader overflowAuto">
        </div> -->
        <div class="w100p h370 overflowAuto uiGridContent">
          <table class="table responsive-table" id="salaryDetailTable">
            <thead>
              <tr>
                @foreach($columns as $column)
                <th>{{$column}}</th>
                @endforeach
              </tr>
            </thead>
            
            <tbody>
                @foreach($salary as $row)
                <tr>
                  @foreach($row as $key=> $column)
                      
                      
                      @if(is_numeric($column) && $key!='employee_id')
                      <td class="right-align">
                        {{"Rp ".number_format($column,2,',','.')}}
                      </td>
                      @else
                      <td>
                        {{$column}}
                      </td>
                      @endif
                  @endforeach
                </tr>
                @endforeach
            </tbody>

            <tfoot class="grey lighten-3 hide-on-med-and-down">
              <tr>
                <td colspan="3">Grand Total</td>
                @foreach($columns as $key => $value)
                <?php
                  if(isset($total[$key])){
                    echo '<td class="right-align"> Rp '.number_format($total[$key],2,'.',',').'</td>'; 

                  }
                 ?>
                
                @endforeach
              </tr>
              
            </tfoot>
            
          </table>
        </div>
      </div>
    </div>
	</div>


@endsection
