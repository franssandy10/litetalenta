$(document).ready(function(){
  $('#new_password').keyup(function() {
    var content = $(this).val();
    /*length */     (content.length < 6) ? $('#length').addClass('fa-times').removeClass('fa-check') : $('#length').removeClass('fa-times').addClass('fa-check').parent().addClass('green-text'); 
    /*letter*/      (content.match(/[A-z]/)) ? $('#letter').removeClass('fa-times').addClass('fa-check') : $('#letter').addClass('fa-times').removeClass('fa-check'); 
    /*lettercase*/  (content.match(/[a-z]/)) ? $('#lettercase').removeClass('fa-times').addClass('fa-check') : $('#lettercase').removeClass('fa-check').addClass('fa-times'); 
    /*uppercase */  (content.match(/[A-Z]/)) ? $('#uppercase').removeClass('fa-times').addClass('fa-check') : $('#uppercase').addClass('fa-times').removeClass('fa-check');
    /*number*/      (content.match(/\d/)) ? $('#number').removeClass('fa-times').addClass('fa-check') : $('#number').addClass('fa-times').removeClass('fa-check');

    $('#tooltipPass ul li i').each(function(){
      var $parent = $(this).parent();
      ($(this).hasClass('fa-times')) ? $parent.addClass('red1-text').removeClass('green-text') : $parent.addClass('green-text text-darken-3').removeClass('red1-text');
    })
  }).focus(function(){
    $('#tooltipPass').addClass('hovered');
  }).blur(function(){
    ($(this).val()) ? $('#tooltipPass').addClass('hovered') : $('#tooltipPass').removeClass('hovered');
  });
})