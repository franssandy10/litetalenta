$(document).ready(function(){
	var slider2 = $('.slider').bxSlider({
        auto: true,
        slideWidth: 200,
        minSlides: 1,
        maxSlides: 3,
        controls: false,
        adaptiveHeight: true,
        pager: false,
        autoStart: true,
        autoHover: true,
        infiniteLoop: false
    });
    $('#employment_status').change(function(){
		var ini = $(this).val();
		if (ini == "1") {
			$('#end_contract_date, #end_probation_date').closest('.input-field').hide();
		}
		else if (ini == "2") {
			$('#end_contract_date, #end_probation_date').closest('.input-field').hide();
			$('#end_contract_date').closest('.input-field').show();
		}
		else {
			$('#end_contract_date, #end_probation_date').closest('.input-field').hide();
			$('#end_probation_date').closest('.input-field').show();
		}
	}).change();
	$('#updateSalary').click(function(){
		var salary = $(this).attr('data-salary');
		$('#modalUpdateSalary #newSalary').val(salary).select();
		vanillaMasker();
		$('#modalUpdateSalary #newSalary').select()
	})
	$('#yesUpdateSalary').click(function(){
		$('#basicSalary').text($('#newSalary').val())
	})
})