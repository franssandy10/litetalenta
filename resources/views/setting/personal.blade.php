@extends('layouts.app')

@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
@endsection

@section('customCss')
  {!! Html::style('assets/plugins/cropper/cropper.min.css')!!}
	{!! Html::style('assets/css/style-setting.css')!!}
@endsection
@include('setting/personal-info/change-avatar')
@include('setting/personal-info/change-password')
@section('content')
	@include('layouts.navbars.header-setting')

	<div class="container">
		<div class="row h-tabRow">
		    <div class="col l2 pad-r-n pad-l-n">
		      <ul class="tabs tab-horizontal">
		        <li class="tab col l12"><a href="#general-info"><i class="talenta-orang-3 fa-3x mb20"></i>Personal<br/>Setting</a></li>
            <li class="tab col l12"><a href="#personal-ess"><i class="talenta-laptop-ess-setting fa-2x mb20"></i>Personal<br/>ESS Setting</a></li>
		      </ul>
		    </div>

		    <!-- tab-content -->
		    <div class="col l10 white pad-l-n h-tabRow">

          <!-- General Info -->
			    <div id="general-info" class="col l12 pad-20 tab-content">
              @yield('changeAvatarHtml')
						  <div class="clearfix"></div>
              @yield('changePasswordHtml')
			    </div>

          <div id="personal-ess" class="col l12 pad-20 tab-content">
            <input type="hidden" id="ess_email" value="{{$model_user->ess_email}}">
            <input type="hidden" id="checkURL" value="{{route('settingpersonaless')}}">
            <div class="row">
              <p class="titleB01">Personal ESS Setting</p>
              <hr class="mt10 mb20">
              <div class="col l12 input-field">
                <div class="input-field col l12 mb30">
                  <input type="checkbox" class="filled-in" id="enableAll">
                  <label for="enableAll">Enable all approval by e-mail</label>
                </div>
                <fieldset id="notificationSetting" >
                  <legend>Personal ESS Notification Setting</legend>
                  <div class="input-field col l12">
                    <input type="checkbox" class="filled-in" id="1" name="timeoff">
                    <label for="1">Approve time-off by e-mail</label>
                  </div>
                  <div class="input-field col l12">
                    <input type="checkbox" class="filled-in" id="2" name="reimbursement">
                    <label for="2">Approve reimbursement by e-mail</label>
                  </div>
             {{-- <div class="input-field col l12">
                    <input type="checkbox" class="filled-in" id="3" name="blablabl">
                    <label for="3">Approve blablablabla</label>
                  </div> --}}
                </fieldset>
              </div>
            </div>
          </div>
		    </div>
		</div>
	</div>


<!-- Modal Structure -->
<div id="modal-cropper" class="modal modal-fixed-footer">
  <div class="modal-content">
    <img src="" id="image-cropping" class="center-align mlAuto mrAuto">
  </div>
  <div class="modal-footer">
    <a href="#!" class=" modal-action modal-close btn btnB01">cancel</a>
    <a href="#!" class="btn btnB01" id="saveImage">SAVE</a>
  </div>
</div>

<!-- Modal Structure -->
<div id="modal-preview" class="modal modal-fixed-footer">
  <div class="modal-content">
  </div>
  <div class="modal-footer">
    <a href="#!" class=" modal-action modal-close btn btnB01">cancel</a>
    <a href="#!" class="btn btnB01" id="saveImage">SAVE</a>
  </div>
</div>
@endsection

@section('customjs')
@yield('changeAvatarIncludeJs')
@yield('changePasswordJs')
<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#image-cropping').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(function() {
	$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
	$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
});

function enableBlabla(cbox_array, status){
    if(status) var bol = 1;
    else var bol = 0;
    var url = $('#checkURL').val();
    var data={};
    var i = 0;
    while(cbox_array[i]){
        data[cbox_array[i].attr('name')] = bol;
        i++;
    }
    console.log(data);
    $.ajax({
      type: 'post',
      url : url,
      data: data,
      dataType:'JSON',
      success: function (response) {
        // for(i=1;i<3;i++){
        var j=0;
        while(cbox_array[j]){
          var msg = cbox_array[j].next('label').html()+' ';
          if(data[cbox_array[j].attr('name')]==false) msg+='disabled';
          else msg+='enabled';
          j++;
          Materialize.toast(msg+'!<i class="fa fa-check ml25"></i>', 2000,'teal');
          // Materialize.toast($('#'+i).attr('id')+'<i class="fa fa-check ml25"></i>', 1500,'teal');
        }
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        console.log('error: '+textStatus);
      }
    });
}

$(document).ready(function(){

  function showHideSetting(){
    var checkedLength = $('#notificationSetting input:checkbox:checked').length;

    if (checkedLength==0) $('#notificationSetting').hide(300);
    else $('#notificationSetting').show(300);

    if (checkedLength == $('#notificationSetting input:checkbox').length) {
      $('#enableAll').prop('checked', true);
    }
    else {
      $('#enableAll').prop('checked', false);
    }
  }

  var ess_email = $('#ess_email').val();
  if(ess_email != ''){
      ess_email = JSON.parse(ess_email);
      for (var key in ess_email) {
         if(ess_email[key]=="1") var status = true;
                            else var status = false;
         $('input[name='+key+']').prop('checked', status);
      }
  }
  showHideSetting();

  $('#enableAll').change(function(){
    var status = this.checked;
    $('#notificationSetting input:checkbox').prop('checked', status);
    status ? $('#notificationSetting').show(300) : $('#notificationSetting').hide(300);
    enableBlabla([$('#1'),$('#2')], status);
  });

  $('#notificationSetting input:checkbox').change(function(){
    var status = this.checked;
    enableBlabla([$(this)], status);
    showHideSetting();
  })
})
</script>
@yield('changeAvatarJs')
@endsection
