@extends('layouts.app')

@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
@endsection

@section('customCss')
  {!! Html::style('assets/css/styleTablePayroll.css')!!}
  <style type="text/css">
    #tableRunPayroll td {
      vertical-align: top;
    }

    #modalEditPayroll #employeeDetail p {
      margin-bottom: 0;
    }
  </style>
@endsection
@section('customjs')

<script type="text/javascript" src="http://mottie.github.io/tablesorter/dist/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="https://mottie.github.io/tablesorter/js/jquery.tablesorter.widgets.js"></script>
  <script type="text/javascript">
    var socket = io.connect("<?=config('database.lite_node_server')?>",{query:"data=<?=UserService::getUserIdHash('payroll')?>&type=payroll"});
    $(document).ready(function(){
      loading();
      if (document.readyState == 'complete') {
        alert('ready, panggil ajax')
      }

      // Run Payroll Button
      $('#runPayroll-btn').click(function(){
        $.ajax({
          method: "GET",
          url: "<?=  route('payrollsystemprocess')?>",
          success:function(data){
            $('#modalRunPayroll').openModal({
              dismissible: false
            })
            setTimeout(function(){
              setTimeout(function(){
                $('.success').slideDown(300);
              }, 500)
              $('.loading').slideUp(300);
              var i = 10;
              var interval =  setInterval(function() {
                                   $('.seconds').text(--i);
                                  if (i == 0) clearInterval(interval);
                              }, 1000);
              setTimeout(function(){
                window.location = "<?=route('report.salarydetail'
                  ,['month_process'=>session('payrolldate')['month'],'year_process'=>session('payrolldate')['year']])?>";
              }, 10000)
            }, 5000)
          }
        })
      }) // Run Payroll Button

      $('#tableRunPayroll').on('click', '.btnEditPayroll', function(){
        thisRow = $(this).closest('tr');
        $("#idEmployee").val($(this).data('id'));
        $('#tableEditPayroll .cloned').remove();
        $.get('payroll-detail/'+$(this).data('id'))
          .done(function(data){
            variable  = {
                      'salary' : data[0].amount,
                      'allowance' : data[1].amount,
                      'deduction' : data[2].amount,
                      'thpTotal':parseInt(unformat(thisRow.find('td:nth-child(5)').text()))
                    };
            $.each(data, function(i, k){
              var $this = $(this);
              if($this[0].amount > 0) {
                  if ($this[0].once == 'yes') {
                    var clone = $('#tableEditPayroll tbody .template:first').clone();
                    clone.find('.componentName').val($this[0].item).attr('name', 'payroll_name[]');
                    clone.find('.componentType').val($this[0].type).attr('name', 'payroll_type[]');
                    clone.find('.componentAmount').val($this[0].amount).attr('name', 'payroll_amount[]');
                  }
                  else {
                    var clone = $('#tableEditPayroll tbody .template2:first').clone();
                    clone.find('.componentName').text($this[0].item);
                    clone.find('.componentType').text($this[0].type);
                    clone.find('.componentAmount').text(parseInt($this[0].amount).format());
                  }
                  clone.addClass('cloned');
                  clone.show();
                  $('#tableEditPayroll tbody').append(clone);
                  vanillaMasker();
              }
            })
            $('#modalEditPayroll #thpTotal').text(variable.thpTotal.format());
            $('#modalEditPayroll .basicSalary').text(parseInt(variable.salary).format());
          });
        $('#modalEditPayroll').openModal();
        $('#modalEditPayroll #employeeDetail').html(thisRow.find('td:first').html());
      });

      $('#tableEditPayroll').on('click', '.removeRow', function(){
        $(this).closest('tr').remove();
      })

      $('#addPayrollAllowance').click(function(){
        var cloneRow = $('#tableEditPayroll .template:first').clone();
        cloneRow.addClass('cloned');
        cloneRow.show();
        cloneRow.find('.componentName').attr('name', 'payroll_name[]');
        cloneRow.find('.componentType').attr('name', 'payroll_type[]');
        cloneRow.find('.componentAmount').attr('name', 'payroll_amount[]');
        cloneRow.removeClass('template');
        $('#tableEditPayroll tbody').append(cloneRow);
        vanillaMasker();
      });

      $('#saveEditPayroll').click(function(){
        debugger;
        allowance = variable.allowance;
        deduction = variable.deduction;
        basicSalary = variable.salary;
        unmask();
        $('#tableEditPayroll tbody tr.cloned [name="payroll_amount[]"]').each(function(){
          var type = $(this).closest('tr').find('.allowance-type').val().toLowerCase();
          type = type == 'allowance_t' || type == 'allowance_nt' ? 'allowance' : 'deduction';
          window[type] = parseInt(window[type]) + parseInt($(this).val());
        });
        var totalPay = parseInt(basicSalary) + parseInt(allowance) - parseInt(deduction);
        console.log("allowance : " + allowance +
                    '\n salary : ' + basicSalary +
                    '\ndeduction : ' + deduction +
                    '\ntotalPay :' + totalPay);
        $form=$(this).parents('form');
        $.ajax({
      		url:$form.attr('action'),
      		method:"POST",
      		dataType:'JSON',
      		data:$form.serializeArray(),
      		success:function(data){
            console.log(data);
            if(data.status=='success'){
              $('#modalEditPayroll').closeModal();
              thisRow.find('td:nth-child(3)').text(allowance.format());
              thisRow.find('td:nth-child(4)').text(deduction.format());
              thisRow.find('td:nth-child(5)').text(totalPay.format());
            }
    			},
      		error:function(data){

            console.log(data);

      		}
      	});
        vanillaMasker();

        var totalAllowance;
        $('.working_days').each(function(k, v){
          var type = $(this).closest('tr').find('.allowance-type').val();
          alert(type);
        })
      })
    }); // Document Ready
    countRow = 0;
     socket.on('connect', function() {
      $.get("{{route('payroll.calldata')}}", function( data ) {
      });
    });
    socket.on("payroll", function (data) {
      nodeTable(data);
      $('#searchLive').keyup();
      $(".table").tablesorter();
      $(".uiGridContent table thead").show();
    });

  </script>
@endsection



@section('content')
  <?php
    $generalHeaderButton = '<a href="#!" class="btn btn02 mr5" id="runPayroll-btn">Run Payroll</a>
        <a href="' . route('payrollindex') . '" class="linkB01">Back to Payroll Menu</a>';
  ?>
  @include('layouts.headers.general')
  <div class="container mt30 dataTablePoint">
<!--     <div class="row">
  <div class="col l12 right-align bBottom pad-b-20">
    <span class="left f24 lato-black">Payroll</span>
    <a href="#!" class="btn btn02 mr5" id="runPayroll-btn">Run Payroll</a>
    <a href="{{ route('payrollindex')}}" class="linkB01">Back to Payroll Menu</a>
  </div>
</div> -->
    <div class="row">
      <div class="col l6">
        <p class="f13 grey-text">Period</p>
        <p class="f16 lato-black">{{$month." ".$year}}</p>
      </div>
      <div class="col l3 right">
        <input type="text" class="search" placeholder="Search" id="searchLive">
      </div>
    </div>
    <div class="row">
      <div class="col l12 positionRelative">
        <div class="w100p uiGridHeader">
        </div>
        <!-- <div class="w100p h370 overflowAuto uiGridContent">
          <table class="table">
            <thead>
            </thead>
          </table>
        </div> -->
        <div class="w100p h370 overflowAuto">
          <table class="table tableHover" id="tableRunPayroll">
            <thead class="grey lighten-3 bold">

            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
	</div>

  <div id="messages" ></div>

  <!-- Modal Run Payroll -->
  <div id="modalRunPayroll" class="modal w100vw h100vh maxHeightNone top0 bgRedGradient1 white-text modal-fullscreen">
    <div class="valign-wrapper h100vh">
      <div class="valign center-align w100p">
        <div class="loading">
          <div class="sk-cube-grid">
            <div class="sk-cube sk-cube1"></div>
            <div class="sk-cube sk-cube2"></div>
            <div class="sk-cube sk-cube3"></div>
            <div class="sk-cube sk-cube4"></div>
            <div class="sk-cube sk-cube5"></div>
            <div class="sk-cube sk-cube6"></div>
            <div class="sk-cube sk-cube7"></div>
            <div class="sk-cube sk-cube8"></div>
            <div class="sk-cube sk-cube9"></div>
          </div>
          <p class="lato-light f30">Running Payroll...</p>
          <p class="f14 lato-light">Please wait, this process might be <a class="modal-action modal-close white-text">take a while</a></p>
        </div>
        <div class="success displayNone">
          <svg width="150" height="100">
            <path id="check" d="M10,30 l30,50 l95,-70" />
          </svg>
          <p class="lato-light f30">Running Success !</p>
          <p class="f14 lato-light">
            We will redirect you to <strong class="lato-bold">Salary Detail</strong> page in <span class="seconds">10</span> seconds<br>
            <a href="<?=route('report.salarydetail'
                  ,['month_process'=>session('payrolldate')['month'],'year_process'=>session('payrolldate')['year']])?>"
                  class="underline white-text">Click here if your browser does not automatically redirect you</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Edit Payroll -->
  <div id="modalEditPayroll" class="modal modal-fixed-footer">
    {!! Form::open(array('url' => 'payroll/system/payroll-detail/')) !!}
    <div class="modal-content">
      <h4 class="titleB01 mb5">Edit Payroll</h4>
      <div class="row">
        <div class="col l12">
          <div id="employeeDetail">

          </div>
          <input type="hidden" name="employee_id" id="idEmployee">
        </div>
      </div>

      <div class="row">
        <div class="col l12">

          <table class="tableHover bordered" id="tableEditPayroll">
            <thead>
              <tr>
                <th class="left-align">Item</th>
                <th width="200">Type</th>
                <th width="200" class="right-align">Amount</th>
                <th width="30"></th>
              </tr>
            </thead>
            <tbody>
              <tr class="template dipslayNone">
                <td class="bold">
                  <input type="text" class="input1 componentName">
                </td>
                <td>
                  <div class="select-wrapper2">
                    <select class="browser-default default3 componentType allowance-type">
                      <option value='allowance_t'>Allowance Taxable</option>
                      <option value='allowance_nt'>Allowance Non-taxable</option>
                      <option value='deduction_t'>Deduction Taxable</option>
                      <option value='deduction_nt'>Deduction Non-taxable</option>
                    </select>
                    <span></span>
                  </div>
                </td>
                <td class="right-align">
                  <input type="text" class="input1 money focus right-align componentAmount" value="0">
                </td>
                <td><a href="#!" class="removeRow red1-text"><i class="fa fa-times"></i></a></td>
              </tr>
              <tr class="template2 displayNone">
                <td class="bold componentName">Basic Salary</td>
                <td class="componentType">Salary</td>
                <td class="right-align componentAmount">18.000.000</td>
                <td></td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
      <div class="row">
        <div class="col l12">
          <a class="valign-middle red1-text mt20" href="#!" id="addPayrollAllowance"><i class="talenta-tambah displayInlineBlock fa-2x mr5"></i>Add New Item</a>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <span class="lato-black f16 pad-10 left">Take Home Pay : <span id="thpTotal"></span></span>
      <a href="#!" class="modal-action modal-close btn btnB01 mr5">Cancel</a>
      <a href="#!" class="btn btnB01" id="saveEditPayroll">Save</a>
    </div>
    {!! Form::close()!!}
  </div>
@endsection
