@section('listpolicyHtml')
<div id="policy" class="tab-content">


    <div class="row">
      <div class="col l12">
        <div class="disabledWarningDiv">
          <div class="col l1 center-align">
            <img src="assets/images/warning1.png" class="responsive-img">
          </div>
          <div class="col l10">
            <p>Warning: Policy(s) that has been created cannot be edited in regards to its effect and complications its records. If you need to make changes, you can do so by creating new policy.</p>
          </div>
        </div>
      </div>
    </div>
  <div class="row">
    <div class="col l3 m6 s12 pad-t-20">
      <a href="#modalAddReimbursement" class="modal-trigger grey-text lato-bold"><i class="talenta-tambah displayInlineBlock mr5 fa-2x"></i>Add New Policy</a>
    </div>
        <div class="col l3 s12 m6 right">
          <input type="text" class="search" placeholder="Search" id="searchLive">
        </div>
    </div>

    <div class="row">
      <div class="col l12 positionRelative">
        <div class="w100p maxHeight370 overflowAuto">
          <table class="table responsive-table">
            <thead class="grey lighten-3 bold">
        <tr>
          <th>Policy Name</th>
          <th>Limit</th>
          <th>Period</th>
          <th>Approver</th>
          <th>Effective Date</th>
          <th>Expired Date</th>
          <th width="100"></th>
        </tr>
            </thead>
            <tbody>
              @foreach($list as $data)
              <tr id="{{$data['id']}}" class="cursorPointer detail-policy detailPolicy" href="#modalDetailPolicy"  data-id="{{$data['id']}}">
                <td>{{$data['name']}}</td>
                <td>{{$data->getLimitFormat()}}</td>
                <td>{{$data->getLimitTypeFormat()}}</td>
                <td>{{$data->getApproverListName()}}</td>
                <td>{{Carbon\Carbon::parse($data['effective_date'])->format('d F Y')}}</td>

                <td>{{($data['deleted_at']==NULL)? "-" : Carbon\Carbon::parse($data['deleted_at'])->format('d F Y')}}</td>
                <td>
                  <!-- <a href="#!" data-tooltip="Detail Policy" class="red1-text mr5 detailPolicy" data-id="{{$data['id']}}"><i class="fa fa-eye"></i></a> -->
                  <a href="#!" data-tooltip="Balance per Employee" class="red1-text mr5 viewBalanceIcon" data-id="{{$data['id']}}"><i class="fa fa-user"></i></a>
                  @if ($data['deleted_at']==null)
                      <a href="#!" class="editPolicyIcon red1-text bold" data-tooltip="Edit Policy"><i class="fa fa-gear mr5"></i></a>
                      <a href="#!" data-tooltip="Expire Policy" class="red1-text deletePolicyIcon"><i class="fa fa-times f18"></i></a>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

  <!-- Modal Reimbursement Balance -->
  <div id="modalBalance" class="modal modal2">
    <div class="modal-content">
      <a href="#!" class="modal-action modal-close grey-text closeModal"><i class="fa fa-times"></i></a>
      <input type='hidden' id='modalBalance-id'>
      <div class="row">
        <div class="col l7 m6 s12">
          <p class="red1-text lato-black f20 mt20">Reimbursement Balance By Employee</p>
        </div>
            <div class="col l3 m6 s12 right">
              <input type="text" class="search searchLive" placeholder="Search">
            </div>
        </div>
      <div class="row">
          <div class="col l12 positionRelative">
            <div class="w100p maxHeight370 overflowAuto">
              <table class="table responsive-table">
                <thead class="grey lighten-3 bold">
            <tr>
                      <th class="no-sort">Photo</th>
                      <th>Full Name</th>
                      <th>Employee ID</th>
              <th>Quota</th>
              <th>Taken</th>
              <th>Balance</th>
              <th width="100"></th>
            </tr>
                </thead>
                <tbody id="tbody-balance">
                  {{--  put clones of employee balance row here  --}}
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
  </div>

  {{-- template for employee balance row --}}
  <table class='hide'>
  <tr id="tr-balance-template" class="tr-balance">
    <td width="50"><img class="circle" width="50" src="{{asset(config('param.url_uploads').'blank.jpg')}}"/></td>
    <td id="modalBalance-name"></td>
    <td id="modalBalance-employeeCode"></td>
    <td id="modalBalance-quota" class="modalBalance-quota"></td>
    <td id="modalBalance-taken"></td>
    <td id="modalBalance-balance"></td>
    <td id="modalBalance-button">
      <a href="#!" class="editBalance linkB01 cursorPointer">Edit Quota</a>
    </td>
  </tr>
  </table>
</div>
@endsection
@section('policyjs')
<script>
  var detailId;
  $(document).ready(function(){
    // $('.cancelPolicy').click(function(e){
    //   e.stopPropagation();
    //   $('#modalDeleteReimbursement').openModal();

    //   deleteReimbursementID = $(this).data('id');
    //   target = $(this);
    // });
    $('body').on('click','.editBalance',function(){
      var tdquota = $(this).closest('tr').find('.modalBalance-quota');
      tdquota.html("<input type='text' class='w50 money' value='"+tdquota.html()+"'>");
      $(this).closest('td').html('<a href="#!" class="saveBalance btn btnB01 cursorPointer">Save</a>');

      vanillaMasker();
    });

    $('body').on('click','.saveBalance',function(){
      unmask();
      var td = $(this).closest('td');
      var tdbalance = td.prev();
      var taken = tdbalance.prev().html();
      var tdquota = $(this).closest('tr').find('.modalBalance-quota');
      var val = tdquota.find('input').val();
      data={
        'balance' : val,
        'employee_id' : $(this).closest('tr').attr('id').slice(8),
        'policy_id' : $('#modalBalance-id').val(),
      };
      $.ajax({
        url:"{{route('reimbursement.edit.balance')}}",
        method:"POST",
        dataType:"JSON",
        data:data,
        success: function(response){
          vanillaMasker();
          if(response.status=='success'){
            successMessage = 'Successfully update balance';
            tdquota.html(tdquota.find('input').val());
            tdbalance.html(response.newbalance);
            td.html('<a href="#!" class="editBalance linkB01 cursorPointer">Edit Quota</a>');
            Materialize.toast(successMessage+'<i class="fa fa-check ml25"></i>', 3000,'teal');
          } else {
            $.each(response,function(x,y){
              $.each(y,function(a,b){
                Materialize.toast(b+' <i class="fa fa-times ml25"></i>', 3000,'red accent-4');
              });
            });
          }
        },
        error:function(response){
          vanillaMasker();
          console.log(response);
        }
      });
    });
    $('.viewBalanceIcon').click(function(e){
      e.stopPropagation();
      var id = $(this).closest('tr').attr('id');
      $('.lastTemplate').remove();
      $.ajax({
        type:"get",
        url: "{{route('reimbursementbalancelist')}}" + "/" + id,
        success: function (response) {

          $('#tbody-balance').html('');
          $.each(response,function(x,employee){
              var row = $('#tr-balance-template').clone();
              row.addClass('lastTemplate');
              row.attr('id','balance-'+employee.id);
              row.find('#modalBalance-name').html(employee.name);
              row.find('#modalBalance-employeeCode').html(employee.employee_id);
              row.find('#modalBalance-taken').html(employee.taken);
              if(employee.quota){
                row.find('#modalBalance-quota').html(employee.quota);
                row.find('#modalBalance-balance').html(employee.balance);
                if(employee.isunlimited) row.find('.editBalance').remove();
                // row.find('#modalBalance-button').html(response[i].quota - response[i].taken);
              } else {
                row.find('#modalBalance-quota').html('0');
                row.find('#modalBalance-balance').html('0');
                //row.find('#modalBalance-button').html('');
              }
              $('#tbody-balance').append(row);
          });
          $('#modalBalance-id').val(id);
          $('#modalBalance').openModal();
        },
        error: function(data){
            console.log(data);
        }
      });
    });

    $('.deletePolicyIcon').click(function(e){
      e.stopPropagation();
      var id = $(this).closest('tr').data('id');
      $('#modalDP-id').val(id);
      $('#buttonDeleteReimbursement').trigger('click');
    });

    $('#yesDeletePolicy').click(function(){
      $(this).addClass('disabled');
      var data = {};
      data['id'] = $('#modalDP-id').val();
      $.post('{{route("reimbursement.policy.expire")}}', data) //{ _token: "{{ csrf_token() }}",data:deleteReimbursementID})
      .done(function( data ) {
        if (data.status = 'success'){
          Materialize.toast('Expire Successfully <i class="fa fa-check ml25"></i>', 3000,'teal');
          $(this).removeClass('disabled');
          window.location.href = data.url;
          window.location.reload();
        }
      });
    })
    
    $('.editPolicyIcon').click(function(e){
      e.stopPropagation();
      var id = $(this).closest('tr').attr('id');
      $('#createPolicyField').hide();
      $('#modalAddReimbursement').find('form').attr('action',"{{route('reimbursement.edit.assign')}}");
      $('#modalAddReimbursement').find('.titleB01').html('Edit Policy');
      $('#modalEP-id').val(id);
      $('#employeeListWrap input:checkbox').prop('checked',false);
      $.ajax({
        url:"{{route('reimbursement.edit.assign')}}/" + id,
        method:"GET",
        dataType:'JSON',
        success: function(response){
          //check/uncheck default
          if (response.default==true){
            $('#default_flag').prop('checked',true);
          } else {
            $('#default_flag').prop('checked',false);
          }
          //check  all employee who has his id in response
          console.log(response);
          $.each(response.employees,function(index,element){
            console.log(element);
            $('#searchEmployee_'+element+"_emp").prop('checked',true);
          });


          var checkedLength = $('#employeeListWrap input:checkbox:checked').length;
          // if (checkedLength==0) $('#notificationSetting').hide(300);
          // else $('#notificationSetting').show(300);

          if (checkedLength == $('#employeeListWrap input:checkbox').length) {
            $('#allEmployee').prop('checked', true);
          // $('#employeeListWrap').hide();
          } else {
            $('#allEmployee').prop('checked', false);
            // $('#employeeListWrap').show();
          }

          $('#modalAddReimbursement').openModal({
          complete: function(){
            $('#createPolicyField').show();
            $('#modalAddReimbursement').find('form').attr('action',"{{route('reimbursement.create')}}");
            $('#modalAddReimbursement').find('.titleB01').html('Create New Policy');
          }
        });
        }
      });
    });

    $(".detailPolicy").click(function(){
      var id=$(this).data('id');
      detailId=id;
      var data={};
      data['id']=id;
      var url='{{route("reimbursement.policy.detail")}}';

      $.ajax({
        type:"get",
        url: url,
        data: data,
        async: false,
        success: function(data){
          if (data.deleted_at) $('#buttonDeleteReimbursement').hide();
          else $('#buttonDeleteReimbursement').show();
          $.each(data,function(x,y){
            $("#modalDetailPolicy #"+x).text(y);
            if(x=='unlimited_flag' && y==1){
              $("#unlimited").removeClass('displayNone');
              $("#withlimit").addClass('displayNone');
            }
            else if(x=='unlimited_flag' && y==0){
              $("#withlimit").removeClass('displayNone');
              $("#unlimited").addClass('displayNone');
            }
          });
          $('#modalDP-id').val(id);
        },

      });
      $('#modalDetailPolicy').openModal();
    });
  });
</script>
@endsection
