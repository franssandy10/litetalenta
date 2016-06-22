@extends('layouts.app')

@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
@endsection

@section('customCss')
{!! Html::style('assets/css/addEmployee.css')!!}
<style type="text/css">
	.bx-wrapper .bx-viewport {
		overflow-y: auto !important;
	}
</style>
@endsection
@include('employee/employee-add/personal')
@include('employee/employee-add/company-detail')
@if ($status_payroll=== true)
  @include('employee/employee-add/payroll-detail')
@endif

@section('customjs')
{!! Html::script('assets/plugins/jquery.bxslider/jquery.bxslider.min.js')!!}
@yield('personaljs')
@yield('companydetailjs')
@yield('payrolljs')
<script type="text/javascript">
	$(document).ready(function(){
	    // validate Data
	    function validateForm($form){
	    	unmask()
	    	$('#address_input').val(addressTampung);
	      $.ajax({
	        url:$form.attr('action'),
	        method:"POST",
	        dataType:'JSON',
	        data:$form.serializeArray(),
	        success:function(data){
	          if(data.status=='success'){
	            nextStep();
	          }
	          console.log(data);
	          vanillaMasker();
	          $('#address_input').val(addressTampung + '\n' + $('#city').val() + ' ' + $('#postal_code').val()).trigger('keyup');
	        },
	        error:function(data){
	          console.log(data);
	          vanillaMasker();
            $.each(data.responseJSON,function(x,y){
                $("#"+x).addClass('invalid');
                Materialize.toast(y+' <i class="fa fa-times ml25"></i>', 3000,'red accent-4');
            });
	          $('#address_input').val(addressTampung + '\n' + $('#city').val() + ' ' + $('#postal_code').val()).trigger('keyup');
	        }
	      });
	    }

		//$(".main").onepage_scroll();
		sliderAddEmployee = $('.bxslider').bxSlider({
		    controls: false,
		    pager: false,
		    infiniteLoop: false,
		    touchEnabled: false,
		    onSliderLoad: function(){

		    }
		});

		$('.nextStep').click(function(){
			$form=$(this).parents('.container').find('form');
			validateForm($form);
		});

		$('.prevStep').click(function(){
		    prevStep();
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
		});

		$('#firstEmployee').change(function(){
			var status = $(this).is(':checked');
			if (status == true) {
				$.ajax({
					url : "{{route('json.useraccess')}}",
					method:"GET",
	        		dataType:'JSON',
	        		success: function(data){
	        			$.each(data.user, function(i, v){
	        				//console.log(i + ' : ' + v + '\n');
	        				$('#personalData').find('input[name="' + i + '"]').val(v).focus().blur();
	        				if (i == 'name') {
	        					var lastspace	= v.lastIndexOf(" ");
	        					var first_name	= v.substring(0, lastspace);
	        					var last_name	= v.substring(lastspace + 1);

	        					$('#personalData').find('input[name="first_name"]').val(first_name).focus().blur();
	        					$('#personalData').find('input[name="last_name"]').val(last_name).focus().blur();
	        				}
	        			})
	        		}
				})
			}
			else {
				$('#personalData form')[0].reset();
			}
		})

		$('#personalData input, #personalData textarea').focus(function(){
			var id = $(this).attr('id');
			if (id == 'city' || id == 'postal_code' || id == 'address_input') {
				$('#addressBox').slideDown(200);
				if (id != 'city' || id != 'postal_code') {
					$('#address_input').val(addressTampung).trigger('keyup');
				}
			}
			else {
				$('#addressBox').slideUp(200);
				$('#address_input').val(addressTampung + '\n' + $('#city').val() + ' ' + $('#postal_code').val()).trigger('keyup');
			}
		})

		$('textarea#address_input').on('keydown, click, change', function(){
			addressTampung = $(this).val();
		});

		function addStructure(element){ // element = input[type="text"]
			var selectElement = element.closest('.input-field').find('select');
			if (  element.hasClass('invalid') == false){
				var type = element.closest('.addNewBox').attr('id');
				var nameData = selectElement.val();
				$.post( "{{route('employee.insert_structure')}}"
				, { _token: "{{ csrf_token() }}", new_data:nameData ,type:type} )
				.done(function( data ) {
					selectElement.find('option:contains("'+nameData+'")').val(data);
				});
			}
		}

		$("#add_department input[type='text'], #add_job input[type='text']").keyup(function(e){
			if (e.which == 13) {
				addStructure($(this));
			} else $(this).removeClass('invalid');
		})

		$("#add_department a, #add_job a").click(function(){
			addStructure($(this).prev());
		})

	}) // Document Ready

	addressTampung = $('textarea#address_input').val();

	function nextStep() {
	    sliderAddEmployee.goToNextSlide();
	    $('body').animate({scrollTop : 0});
	    var current = parseInt(sliderAddEmployee.getCurrentSlide()) + 1;

	    for (var i = 0; i < current; i++) {
	      $('.customStep li:nth-child(' + current + ')').addClass('black-text hide-on-med-and-down');
	      $('.customStep li').addClass('hide-on-med-and-down');
	      if (i = current) $('.customStep li:nth-child(' + i + ')').removeClass('hide-on-med-and-down')
	    }
	}

	function prevStep() {
	    sliderAddEmployee.goToPrevSlide();
	    $('body').animate({scrollTop : 0});
	    var current = parseInt(sliderAddEmployee.getCurrentSlide()) + 1;

	    for (var i = 0; i < current; i++) {
	      $('.customStep li:nth-child(' + current + ')').addClass('black-text hide-on-med-and-down');
	      $('.customStep li').addClass('hide-on-med-and-down');
	      if (i = current) $('.customStep li:nth-child(' + i + ')').removeClass('hide-on-med-and-down')
	    }
	}
</script>

@endsection

@section('content')
<div class="container mt15">
	<div class="row">
		<div class="col l12 s12 grey lighten-2">
		  <ol class="customStep mt0 mb0">
		    <li class="black-text"><span>1</span>Personal Data</li>
		    <li class="hide-on-med-and-down"><span>2</span>Company Detail</li>
        @if ($status_payroll=== true)
          <li class="hide-on-med-and-down"><span>3</span>Payroll</li>
        @endif
        	<li class="hide-on-med-and-down"><span>4</span>Finish</li>
		  </ol>
		</div>
	</div>
</div>


<ul class="bxslider mb40 ml0 mr0">

	<!-- Personal Data -->
  @yield('personalHtml')
  @yield('companyDetailHtml')

  @yield('payrollDetailHtml')



	<!-- Success -->
	<li>
		<div class="container">
			<div class="row">
		        <div class="col l12 center-align grey lighten-2 white-text pad-20">
		          <h2 class="ls3 text-uppercase f22 lato-black">You have successfully Add New Employee</h2>
		        </div>
		    </div>
		    <div class="row">
		        <div class="col l12 mt40 center-align">
		          <a onClick="location.reload()" class="btn btnB01">Add More Employees</a>
		        </div>
		    </div>
		</div>
	</li>
</ul>
@include('payroll.component.add-modal')
@endsection
