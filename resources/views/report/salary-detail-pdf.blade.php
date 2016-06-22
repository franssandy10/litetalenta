<!DOCTYPE html>
<html>
<head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <link href='assets/css/stylePdf.css' rel='stylesheet' type='text/css'>

  <style type="text/css">
    table {
      width: 100%;
      font-family: sans-serif !important;
      border-collapse: collapse;
    }

    table.no-padding tr td {
      padding: 0 !important;
    }

    table.no-padding tr td p {
      margin-top: 0;
      margin-bottom: 0;
    }
  </style>
</head>
<body class="pad-20 pad-t-none">
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
  </body>
</html>
