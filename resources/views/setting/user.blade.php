@extends('layouts.app')

@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
@endsection

@section('customCss')
	{!! Html::style('assets/css/style-setting.css')!!}
	{!! Html::style('assets/plugins/dataTable/datatables.min.css')!!}
@endsection

@section('customjs')
	{!! Html::script('assets/plugins/dataTable/datatables.min.js')!!}
	{!! Html::script('assets/js/scriptDataTable.js')!!}
  <script type="text/javascript">
  $(document).ready(function(){
    $('.remove').click(function(){
      $("#remove_id").val($(this).parents('tr').find('.user_id').val());
      $('#modalRemove').openModal();
    });
    $('select.change').change(function(){
      $("#access_id").val($(this).parents('tr').find('.user_id').val());
      $("#role").val($(this).val());
      $('#modalChange').openModal();
    });
    $(".yesButton").click(function(){
      $form=$(this).parents('form');
      // $form.submit();
      validateForm($form);
    });
  });
  </script>
@endsection

@section('content')
	@include('layouts.navbars.header-setting')

	<div class="container">
		<div class="row h-tabRow">
			<div class="col l12 white pad-l-n h-tabRow">
				<div class="settingDiv">
					<div class="row">
							<custom>
								<a href="#modalInvitation" class="btn btnB01 modal-trigger mt10 left" id="inviteEmployeeBtn">
									<i class="fa fa-plus-circle left mtm3"></i> <span class="left"> INVITE EMPLOYEE </span>
								</a>
							</custom>
						<div class="col l12">

							<table class="dataTable" id="table-user">
								<thead class="grey lighten-3">
									<tr>
										<td class="center-align no-sort">Photo</td>
										<td class="center-align">Fullname</td>
										<td class="center-align">Rule</td>
										<td class="center-align">Action</td>
									</tr>
								</thead>
								<tbody>
                  @foreach ($list as $user)
									<tr>
										<td class="center-align" width="50"><img class="circle responsive-img" width="50" src="{{$user->getAvatar()}}"/></td>
										<td class="red1-text lato-bold center-align">{{$user->userAccess->name}}<input type="hidden" class="user_id" value="{{$user->id}}"/></td>
										<td class="center-align" width="150">
                      <?= Form::select('role_id', UserService::getListRole(),$user->userAccess->getRoles()[0]->id,['class'=>'enter_disabled change']); ?>
										</td>
										<td class="center-align" ><a class="remove red1-text">Remove Access</a></td>
									</tr>
                  @endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

 <!-- Modal Invite -->
  <div id="modalInvitation" class="modal modal-fixed-footer">
    {!! Form::open(array('route' => 'invitation')) !!}
    <div class="modal-content">
      <h4 class="titleB01">Invite Employee</h4>
      <hr class="mb40">
      <p>After importing your employee database to Talenta, now it’s time to invite them to the platform. They will receive e-mails to create their account and it will just take a few minutes before they can start accessing Talenta. Inviting is as easy as selecting which employee you will give access to Talenta, and then click the send invitation button.</p>
      <div class="row">
      	<div class="col l12">
      		<table class="dataTable" id="table-invite">
      			<thead class="grey lighten-3">
      				<tr>
      					<td width="50" class="no-sort">
      						<div class="col l12 input-field mtm10">
      							<input type="checkbox" class="filled-in check-all" id="check-all">
      							<label for="check-all"></label>
      						</div>
      					</td>
      					<td>Name</td>
      				</tr>
      			</thead>
      			<tbody>
              @foreach($employees as $user)
      				<tr>
      					<td>
      						<div class="col l12 input-field mtm10">
      							<input type="checkbox" class="filled-in" id="{{$user->employee_id_fk}}" name="employee[]" value="{{$user->employee_id_fk}}">
      							<label for="{{$user->employee_id_fk}}"></label>
      						</div>
      					</td>
      					<td>
                  <b>{{$user->userEmployee->first_name." ".$user->userEmployee->last_name}}</b> - {{$user->userEmployee->email}}
                </td>
      				</tr>
              @endforeach
      			</tbody>
      		</table>
      	</div>
      </div>
    </div>
    <input class="text_success" type="hidden" value="Email Sent to Employee"/>
    <div class="modal-footer">
		    <a href="#!" class="modal-action modal-close btn btnB01">Close</a>
    	<a href="#!" class="modal-action btn btnB01 mr5 submitButton">Send Invitation</a>
    </div>
    {!! Form::close() !!}

  </div>
  <div id="modalRemove" class="modal modal-fixed-footer modal-confirm">
    {!! Form::open(array('route' => 'access.remove')) !!}

  		<div class="modal-content">
  		  <h4 class="titleB01">Delete?</h4>
  		  <div class="row">
  		  	<div class="col l12 s12 input-field">
  		  		<p>Are you sure want to delete this user?</p>
            <input type="hidden" name="employee" id="remove_id" value=""/>
  		  	</div>
  		  </div>
  		</div>
      <input class="text_success" type="hidden" value="Successfull Remove Access!"/>
  		<div class="modal-footer">
  		  <a href="#!" class="modal-action modal-close btn btnB01">No</a>
  		  <a href="#!" class="modal-action modal-close btn btnB01 mr5 yesButton">Yes</a>
  		</div>
    {!! Form::close() !!}
	</div>
  <div id="modalChange" class="modal modal-fixed-footer modal-confirm">
    {!! Form::open(array('route' => 'access.change')) !!}

  		<div class="modal-content">
  		  <h4 class="titleB01">Change Access?</h4>
  		  <div class="row">
  		  	<div class="col l12 s12 input-field">
  		  		<p>Are you sure want to change this user to?</p>
            <input type="hidden" name="employee" id="access_id" value=""/>
            <input type="hidden" name="role" id="role" value=""/>

  		  	</div>
  		  </div>
  		</div>
      <input class="text_success" type="hidden" value="Successfull Change Access!"/>
  		<div class="modal-footer">
  		  <a href="#!" class="modal-action modal-close btn btnB01">No</a>
  		  <a href="#!" class="modal-action modal-close btn btnB01 mr5 yesButton">Yes</a>
  		</div>
    {!! Form::close() !!}
	</div>
@endsection
