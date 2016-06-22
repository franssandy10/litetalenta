@section('changeAvatarHtml')
<div class="row">

  <p class="titleB01">Change Profile Picture</p>
  <hr class="mt10 mb20">
  <div class="col l12">
    <img src="{{Sentinel::getUser()->userAccessConnection->getAvatar()}}" class="circle" id="avatar" width="100">
  </div>
  <div class="col l12">
      {!! Form::open(array('url' => route('settingvalidateavatar'),'class'=>'displayNone')) !!}
        <input type="file" id="fileupload">
        {!! Form::text('file_name','',['id'=>'file_name'])!!}
        {!! Form::close() !!}
      <a class="linkB01 mt10" href="#!" id="changePicture">Select New Picture</a>
  </div>

  {!! Form::open(array('url' => route('settingchangeavatar'))) !!}
    <input type="hidden" name="image_data" id="image_data" >
    <div class="col l12 mt10">
      <a href="#!" class="btn btnB01 ml10 submitButton" >save</a>
    </div>
    <input class="text_success" type="hidden" value="Change Avatar Successfully"/>
  {!! Form::close() !!}
</div>
@endsection
@section('cropperAvatarModal')
<!-- Modal Structure -->
<div id="modal-cropper" class="modal modal-fixed-footer">
  <div class="modal-content">
    <img src="" id="image-cropping" class="center-align mlAuto mrAuto">
  </div>
  <div class="modal-footer">
    <a href="#!" class=" modal-action modal-close btn btnB01">cancel</a>
    <a href="#!" class="btn btnB01 modal-action modal-close" id="saveImage">SAVE</a>
  </div>
</div>
@endsection
@section('changeAvatarIncludeJs')
{!! Html::script('assets/plugins/cropper/cropper.min.js')!!}
{!! Html::script('assets/plugins/fileupload/iframe-transport.js')!!}
{!! Html::script('assets/plugins/fileupload/fileupload.js')!!}
@endsection
@section('changeAvatarJs')
<script>
$(document).ready(function(){
  $('#saveImage').click(function(){
    // $('#modal-preview').openModal();
    var result = $('#image-cropping').cropper('getCroppedCanvas', {
      width: 150,
      height: 150
    });
    $("#avatar").attr('src',result.toDataURL());
    $("#image_data").val(result.toDataURL());
    $(this).parents('.modal').closeModal();
  });
  $('#changePicture').click(function(){
    $(this).prev('form').find('input[type="file"]').click();
  });

  $('#fileupload').change(function(){
    $selector=this;
    $form=$(this).parents('form');
    $form.find('#file_name').val($(this).val());
    $.ajax({
  		url:$form.attr('action'),
  		method:"POST",
  		dataType:'JSON',
  		data:$form.serializeArray(),
  		success:function(data){
        console.log(data);
        if(data.status=='success'){
          readURL($selector);
          var imagesrc = $('#image-cropping').attr('src');
          setTimeout(function(){
            $('#modal-cropper').openModal({
              ready: function() {
                var imagesrc = $('#image-cropping').attr('src');
                $('#image-cropping').cropper({
                  aspectRatio: 1 / 1,
                  crop: function(e) {
                    // Output the result data for cropping image.
                    console.log(e.x);
                    console.log(e.y);
                    console.log(e.width);
                    console.log(e.height);
                    console.log(e.rotate);
                    console.log(e.scaleX);
                    console.log(e.scaleY);
                    console.log(e.naturalWidth);
                  }
                });
                $('#image-cropping').cropper('replace', imagesrc);
              }
            });
          }, 100)
  			}
  			else{
  				$.each(data,function(x,y){
  						$("#"+x).addClass('invalid');
  						$.each(y,function(a,b){
  							Materialize.toast(b+' <i class="fa fa-times ml25"></i>', 3000,'red accent-4');
  						});

  				})
  			}

  		},
  		error:function(data){
  			console.log(data);
  		}
  	});

  });

});
</script>
@endsection
