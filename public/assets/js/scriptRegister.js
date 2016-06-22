$(document).ready(function(){
  $("#submitButton").click(function(){
    $.ajax({
      url:$("form").attr('action'),
      method:"POST",
      dataType:'JSON',
      data:$("form").serializeArray(),
      success:function(data){
        if(data.status=='success'){
          Materialize.toast('Register Successfull <i class="fa fa-check ml25"></i>', 3000,'teal');
          $("#triggerButton").trigger('click');
        }
        else{
          $.each(data,function(x,y){
              console.log(x);
              $("#"+x).addClass('invalid');
              Materialize.toast(y+' <i class="fa fa-times ml25"></i>', 3000,'red accent-4');
          })
        }

      },
      error:function(data){
        console.log(data);
      }
    });
  });
});
