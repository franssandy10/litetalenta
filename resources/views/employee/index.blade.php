@extends('layouts.app')
@include('employee.reactEmployee')
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
    {!! Html::script('assets/plugins/fullcalendar-2.4.0/moment.min.js')!!}
    <script type="text/javascript">
      function changeList(checked,employeeID){
        var approverList = $('#approver_list').val();
        var id = employeeID + ','; //contoh: '17,'

        if(checked){ //tambahin id ke approver list
          var srch = approverList.indexOf(id);
          if (srch==-1) approverList += id; //else berarti udah ada, gausa diapa2in
        } else { //ilangin id dari approver list
          var arr = approverList.split(id); //split biar id otomatis ilang dari string
          if(!arr[1]) approverList = arr[0]; //if id not found, use arr[0]
          else approverList = arr[0]+arr[1];
        }
        $('#approver_list').val(approverList);
      }

      var workingShift={};
@foreach ($working_shifts as $shift)
      workingShift['{{$shift['day']}}'] = {
          checked_in_hour   :'{{ (strlen($shift['start_hour'])==1)? '0'.$shift['start_hour'] : $shift['start_hour'] }}',
          checked_in_minute :'{{ (strlen($shift['start_minute'])==1)? '0'.$shift['start_minute'] : $shift['start_minute'] }}',
          checked_out_hour  :'{{ (strlen($shift['end_hour'])==1)? '0'.$shift['end_hour'] : $shift['end_hour'] }}',
          checked_out_minute:'{{ (strlen($shift['end_minute'])==1)? '0'.$shift['end_minute'] : $shift['end_minute'] }}'
      }
@endforeach
      function displayAttendanceForm(){
        var url = $('#attendanceRangeURL').val();
        var startDate = Date.parse($('#inputAttendanceStartDate').val());
        var endDate = Date.parse($('#inputAttendanceEndDate').val());
        var data = {};
        data['start']=$('#_inputAttendanceStartDate').val();
        data['end']=$('#_inputAttendanceEndDate').val();
        $.ajax({
          type:'get',
          dataType:'json',
          url:url,
          data:data,
          success:function(response){
              var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
              var diffDays = (endDate - startDate)/oneDay;
              var currentDate = startDate;

              // store template in variable, then clean up to set a fresh blank view
              $('#accordionContainer').html('');
              var tempAccordion = $('.attendance-accordion');
              var tempRow = $('.accor-tr');

              // loop, creating an accordion row each date
              for(i=0; i<=diffDays; i++){
                var date = new Date(currentDate);
                var dateOptions = {weekday:"short", year: "numeric", month: "long", day: "numeric"};
                var dateText = date.toLocaleDateString("hi-inl", dateOptions); //hindia-indonesia
                var dateDBformat = moment(currentDate).format('YYYY-MM-DD');
                var currentWeekday = moment(currentDate).format('dddd').toLowerCase();

                // create accordion row for this date
                var accordion = tempAccordion.clone();
                accordion.find('.accor-dateText').html(dateText);
                accordion.find('[name="date"]').val(dateDBformat);

                // loop, create record rows for each employee
                $.each(response,function(index,value){
                    var row = tempRow.clone();
                    row.find('[name="employee_id_fk[]"]').val(response[index]['id']);
                    row.find('.accor-employeeId').html(response[index]['employee_id']);
                    row.find('.accor-employeeName').attr('data-tooltip',response[index]['first_name']+' '+response[index]['last_name']);
                    row.find('.accor-employeeName').find('p').html(response[index]['first_name']+' '+response[index]['last_name']);

                    if(response[index]['job_position_id_fk']){
                        row.find('.accor-jobPosition').attr('data-tooltip',response[index]['job_position_id_fk']);
                        row.find('.accor-jobPosition').find('p').html(response[index]['job_position_id_fk']);
                    }

                    var temp={};
                    var disabledFlag = false; // untuk disable input Hour & Minute ketika ada timeoff
                    // // check apakah karyawan timeoff di hari ini?
                    for(var i = 0; i < response[index]['employee_time_off_taken'].length; i++) {
                       if(response[index]['employee_time_off_taken'][i].date == dateDBformat) {
                         temp = response[index]['employee_time_off_taken'][i]; // get array index which has attendance on this date
                         temp['checked_in_hour']   = '- -';
                         temp['checked_in_minute'] = '- -';
                         temp['checked_out_hour']  = '- -';
                         temp['checked_out_minute']= '- -';
                         disabledFlag = true;
                         break;
                       }
                    }
                    if (Object.keys(temp).length == 0){ //timeoff not found
                      // set temp to default working shift
                      temp = workingShift[currentWeekday];
                      if(!temp){
                          temp = {
                              checked_in_hour   :'09',
                              checked_in_minute :'00',
                              checked_out_hour  :'17',
                              checked_out_minute:'00'
                          }
                      }
                      // // check apakah sudah ada data attendance di hari ini?
                      for(var i = 0; i < response[index]['employee_attendance'].length; i++) {
                         if(response[index]['employee_attendance'][i].date == dateDBformat) {
                           temp = response[index]['employee_attendance'][i]; // get array index which has attendance on this date
                           break;
                         }
                      }
                      temp["policy_id_fk"]='0'; //no timeoff
                    }

                    row.find('.accor-checkIn').find('[name="checked_in_hour[]"]').val(temp['checked_in_hour']);
                    row.find('.accor-checkIn').find('[name="checked_in_minute[]"]').val(temp['checked_in_minute']);
                    row.find('.accor-checkOut').find('[name="checked_out_hour[]"]').val(temp['checked_out_hour']);
                    row.find('.accor-checkOut').find('[name="checked_out_minute[]"]').val(temp['checked_out_minute']);
                    if(disabledFlag) {
                      row.find('.accor-checkIn').find('input').prop('disabled', true); // disable input
                      row.find('.accor-checkOut').find('input').prop('disabled', true);
                    }
                    row.find('.accor-timeoff').val(temp['policy_id_fk']).trigger('change');

                    accordion.find('tbody').append(row);
                    row.removeClass('hide');
                }); // closure loop for creating rows
                $('#accordionContainer').append(accordion);
                accordion.removeClass('hide');
                currentDate += oneDay;
            }
          },
        })
      }



      $(document).ready(function(){

        $('body').on('change','.attendanceTimeOff',function(){
          if($(this).val()==='') return; // prevent double trigger
          else if($(this).val()==0) var isDisabled = false;
          else var isDisabled = true;

          var checkout = $(this).closest('td').prev();
          checkout.find('input').prop('disabled', isDisabled);

          var checkin = checkout.prev();
          checkin.find('input').prop('disabled', isDisabled);
        })

        $('#employeeListCheck').on('change','input[type="checkbox"]',function(){
          var id = $(this).attr('id').slice(15); //untuk slice id = 'searchEmployee_#'.slice()
          changeList(this.checked,id);
        });

        $('#allEmployee').change(function(){
          $('#employeeListCheck').slideToggle();
          if(this.checked==false){
            //uncheck all checkbox
            $('#employeeListCheck input:checkbox').prop('checked', false);
            $('#approver_list').val('');
          } else {
            $('#approver_list').val('all');
          }
        })

        $('#inputAttendanceStartDate').change(function(){
          if($('#inputAttendanceEndDate').val().length>0){
              displayAttendanceForm();
          }
        })
        $('#inputAttendanceEndDate').change(function(){
          if($('#inputAttendanceStartDate').val().length>0){
              displayAttendanceForm();
          }
        })

      })
    </script>
@endsection
@section('content')
@include('layouts.headers.general')
<div class="container mt30">
    <input type="hidden" id="attendanceRangeURL" value="{{route('attendance.range')}}">
    <div class="row">
      <div class="col s12">
        <nav class="nav3 tab3">
              <div class="nav-wrapper">
                <ul id="tabs3">
                  <li class="tab text-uppercase ls2 pad-l-n"><a href="#employeeList" class="lato-black f12">employee List</a></li>
                  <li class="tab text-uppercase ls2"><a href="#attendanceList" class="lato-black f12">attendance</a></li>
                </ul>
              </div>
          </nav>
      </div>
    </div>

    <div id="employeeList" class="tab-content">
      <div class="col l12 m12 s12 mb30">
          <!-- <a href="#!" class="btnEmployeeIndex">
              <i class="talenta-transfer"></i>
              Import & Export<br>Employee
          </a> -->
          <a href="{!! route('employeecreate') !!}" class="btnEmployeeIndex">
              <i class="talenta-tambah"></i>
              Add<br>Employee
          </a>
          <!-- <a href="{{ route('attendance')}}" class="btnEmployeeIndex">
              <i class="talenta-kalender-5"></i>
              View<br>Attendance
          </a>
          <a href="#!" class="btnEmployeeIndex">
              <i class="talenta-tulisan-1"></i>
              View<br>Schedule
          </a> -->
          <!-- <a href="#!" class="btnEmployeeIndex">
              <i class="talenta-timbangan-1"></i>
              Prorate<br>Setting
          </a> -->
          <!-- <a href="#!" class="btnEmployeeIndex">
              <i class="talenta-orang-kotak"></i>
              Employee Transfer<br>History
          </a>
          <a href="#!" class="btnEmployeeIndex last">
              <i class="talenta-kaca-pembesar"></i>
              Column<br>Search
          </a> -->
      </div>
      <table class="bordered dataTable scroll" id="dataTableFixedCol4">
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
                  <td>Barcode</td>
                  <td>Organization</td>
                  <td>Job Position</td>
                  <td>Job Title</td>
                  <td>Hire Date</td>
                  <td>Status Employee</td>
                  <td>End Date</td>
                  <td>Email</td>
                  <td>Birth Date</td>
                  <td>Birth Place</td>
                  <td>Mobile Phone</td>
                  <td>Religion</td>
                  <td>Gender</td>
                  <td>Marital Status</td>
                  <td>Address</td>
              </tr>
          </thead>
          <tbody>
            @foreach ($employee_list as $employee)
            <tr>
                <td width="20">
                    <div class="col l12 input-field mtm20">
                        <input type="checkbox" class="filled-in" id="{{$employee->id}}">
                        <label for="{{$employee->id}}"></label>
                    </div>
                </td>
                <td width="50"><img class="circle" width="50" src="{{asset(config('param.url_uploads').'blank.jpg')}}"/></td>
                <td><a href="{{route('employeeinfo',['id'=>$employee->id])}}" class="red1-text bold">{{$employee->first_name." ".$employee->last_name}}</a></td>
                <td>{{$employee->employee_id}}</td>
                <td>{{$employee->barcode}}</td>
                <td>{{$employee->Organization}}</td>
                <td>{{UserService::getJobPositionById($employee->job_position_id_fk)}}</td>
                <td>{{UserService::getJobPositionById($employee->job_position_id_fk)}}</td>
                <td>{{$employee->join_date}}</td>
                <td>{{BaseService::getEmploymentStatus($employee->employment_status)}}</td>
                @if($employee->employment_status==1)
                <td>Not Set</td>
                @elseif($employee->employment_status==2)
                <td>{{$employee->end_contract_date}}</td>
                @elseif ($employee->employment_status==3)
                <td>{{$employee->end_probation_date}}</td>
                @endif
                <td>{{$employee->email}}</td>
                <td>{{$employee->date_of_birth}}</td>
                <td>{{$employee->place_of_birth}}</td>
                <td>{{$employee->mobile_phone}}</td>
                <td>{{BaseService::getReligion($employee->religion)}}</td>
                <td>{{BaseService::getGenderById($employee->gender)}}</td>
                <td>{{BaseService::getMaritalStatus($employee->marital_status)}}</td>
                <td>{{$employee->address}}</td>
            </tr>
            @endforeach

          </tbody>
      </table>
    </div>

    <div id="attendanceList" class="tab-content">
      <div class="row">
        <div class="col s2 input-field">
          <input id="inputAttendanceStartDate" type="text" class="datepicker">
          <label for="inputAttendanceStartDate">Start Date</label>
        </div>
        <div class="col input-field">
          <p class="mt10">to</p>
        </div>
        <div class="col s2 input-field">
          <input id="inputAttendanceEndDate" type="text" class="datepicker">
          <label id="inputAttendanceEndDate">End Date</label>
        </div>
        <div class="col right">
          <a href="#modalMassInsert" class="btn btn02 mt10 modal-trigger">mass insert</a>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
            <ul id="accordionContainer" class="collapsible collapsible2" data-collapsible="accordion">
            </ul>
        </div>
      </div>

      {{-- template for accordion --}}
      <li class="attendance-accordion hide">
        <div class="accor-dateText collapsible-header"></div>
        <div class="collapsible-body right-align">
        <form action="{{route('attendance.create')}}">
          <input type="hidden" name="date">
          <table>
            <thead class="grey lighten-3">
              <tr>
                <th width="100">Employee ID</th>
                <th>Name</th>
                <th>Job Position</th>
                <th width="130">Check In</th>
                <th width="130">Check Out</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                {{-- put <tr> here --}}
            </tbody>
          </table>
          <a href="#!" class="btn btn02 submitButton mb30">Save</a>
          <input class="text_success" type="hidden" value="Update Attendance(s) Successfull"/>
        </form>
        </div>
      </li>

    {{-- template for tr --}}
    <table>
      <tr class="accor-tr hide">
        <input type="hidden" name="employee_id_fk[]">
        <td class="accor-employeeId"> </td>
        <td class="accor-employeeName">
            <p class="truncate">
            </p>
        </td>
        <td class="accor-jobPosition">
              <p class="truncate">
              </p>
        </td>
      <td class="accor-checkIn">
        <input name="checked_in_hour[]" type="text" maxlength="2" class="input1 w50 center-align focus mr5">
        <input name="checked_in_minute[]" type="text" maxlength="2" class="input1 w50 center-align focus mr5">
      </td>
      <td class="accor-checkOut">
        <input name="checked_out_hour[]" type="text" maxlength="2" class="input1 w50 center-align focus mr5">
        <input name="checked_out_minute[]" type="text" maxlength="2" class="input1 w50 center-align focus mr5">
      </td>
      <td>
       <div class="input-field mt0">
       <?=Form::select('timeoff[]', UserService::getTimeOffPolicies('No Time Off',0),'', ['class'=>'accor-timeoff validate browser-default default3 enter initialized attendanceTimeOff']); ?>
          <!-- <select name="timeoff[]" class="accor-timeoff validate browser-default default3 enter initialized attendanceTimeOff">
            <option value="0"> No Time Off </option>
            <option value="1"> Holiday </option>
            <option value="2"> Sick </option>
          </select> -->
          <span></span>





       </div>
      </td>
    </tr>
    </table>


    </div>
</div>

<!-- Modal Mass Insert -->
<div id="modalMassInsert" class="modal modal2 modal-fixed-footer">
<form action="{{route('attendance.massinsert')}}">
  <div class="modal-content">
    <h4 class="titleB01">Mass Attendance</h4>
    <div class="row">
      <div class="col s5 input-field">
        <input name="start_date" type="text" class="datepicker form_default">
        <label>Start Date</label>
      </div>
      <div class="col input-field">
        <p class="mt10">to</p>
      </div>
      <div class="col s5 input-field">
        <input name="end_date" type="text" class="datepicker form_default">
        <label>End Date</label>
      </div>
    </div>
    <div class="row mb5">
      <div class="col s6">
        <p>Check In Time</p>
        <input name="checked_in_hour" type="text" class="input1 w50 mr5 form_default" value="09">
        <input name="checked_in_minute" type="text" class="input1 w50 mr5 form_default" value="00">
      </div>
      <div class="col s6">
        <p>Check Out Time</p>
        <input name="checked_out_hour" type="text" class="input1 w50 mr5 form_default" value="17">
        <input name="checked_out_minute" type="text" class="input1 w50 mr5 form_default" value="00">
      </div>
    </div>
    <div class="row">
      <input type="hidden" id="approver_list" name="employee_id_fk" value="">
      <div class="col s12 input-field mt0">
        <input type="checkbox" id="allEmployee" name="all_employee" class="filled-in">
        <label for="allEmployee">All Employee</label>
      </div>
      <div class="col s11 offset-s1 pad-l-n mt10" id="employeeListCheck">
        @include('employee/list')
      </div>
    </div>

  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-action modal-close btn btnB01">Cancel</a>
    <a href="#!" class="btn btnB01 submitButton">Confirm</a>
    <input class="text_success" type="hidden" value="Input Attendances Successfull" >
  </div>
</form>
</div>

    <!-- Bootstrap Boilerplate... -->
<!-- <div class="panel-body">
        <form action="/task" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="task" class="col-sm-3 control-label">Task</label>

                <div class="col-sm-6">
                    <input type="text" name="name" id="task-name" class="form-control">
                </div>
            </div>

            <div class="form-group"
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Add Task
                    </button>
                </div>
            </div>
        </form>
    </div> -->


@endsection
