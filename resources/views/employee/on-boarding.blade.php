@extends('layouts.app')

@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
 @endsection

 @section('content')
	<div class="row bgRed2 onBoarding pad-40">
		<div class="container">
			<div class="col l8 offset-l2 s12 center-align">
				<h1 class="lato-light f30 white-text mt0">Create Onboarding Page</h1>
				<p class="f14 white-text lineHeight35px">Creating an onboarding page gets your new hire started on the right foot. Assign tasks and paperwork, show them the people and tools they’ll work with, and provide the info they need to show up on their first day well-informed.</p>
				<a href="#!" class="btn btnB01 bWhite white-text">start</a>
			</div>
		</div>
	</div>

	<div class="row bBottom onBoarding pad-40">
		<div class="container">
			<div class="col l6 offset-l3 s12 center-align">
				<p class="titleB01">Assign to new employee</p>
				<p class="titleB01 lato-light grey-text">Please enter employee name</p>
				<div class="col l12 s12 input-field">
					<input type="text" id="employeeName">
					<label for="employeeName">Employee Name</label>
				</div>
				<a href="#!" class="btn btnB01 mt30">Next</a>
			</div>
		</div>
	</div>

	<div class="row bBottom onBoarding pad-40">
		<div class="container">
			<p class="titleB01 center-align">Joshua Kevin's Onboarding Page</p>
			<p class="titleB01 lato-light grey-text center-align mb30">Select the arrival date & write an instructions</p>
			<div class="col l6 s12">
				<label class="lato-light grey-text f13 bold mb30">Select date</label>
				<div class="calendar mt30 mb20">
					
				</div>
			</div>
			<div class="col l6 s12">
				<div class="col l12 s12 input-field">
					<select>
						<option>09:00 AM</option>
						<option>10:00 AM</option>
						<option>11:00 AM</option>
						<option>12:00 AM</option>
					</select>
					<label class="lato-light grey-text f13 bold">Select time</label>
				</div>
				<div class="col l12 s12 input-field">
					<input type="text" id="instruction">
					<label for="instruction">Instructions</label>
				</div>
			</div>
			<div class="col l12 s12 center-align mt30">
				<a href="#!" class="btn btnB01">next</a>
			</div>
		</div>
	</div>

	<div class="row onBoarding pad-40">
		<div class="container">
			<p class="titleB01 center-align">Joshua Kevin's Onboarding Page</p>
			<p class="titleB01 lato-light grey-text center-align mb30">Add task for Joshua</p>
			<div class="col l8 offset-l2 s12">
				<ul id="task">
					<li class="relative">
						<p class="lato-black red1-text mb0">Bring a photo ID on your first day</p>
						<p class="mt0 grey-text lato-black">Please bring a valid state ID (driver's license) or a passport on your first day.</p>
						<i class="fa fa-times right absolute top0 right0 cursorPointer deleteTask"></i>
					</li>
				</ul>
				<div class="col l12 s12 addTask mt30 modal-trigger" href="#modalCreateTask">
					<p class="f30 center-align lato-bold"><i class="fa fa-plus-circle"></i> Create a New Task</p>
				</div>
				<div class="col l12 s12 addTask mt30 modal-trigger" href="#modalAddTask">
					<p class="f30 center-align lato-bold"><i class="fa fa-plus-circle"></i> Add Task</p>
				</div>
			</div>
			<div class="col l12 s12 center-align mt30">
				<a href="#!" class="btn btnB01">finish</a>
			</div>
		</div>
	</div>

	<!-- Modal Create Task -->
	<div id="modalCreateTask" class="modal modal-fixed-footer modal1">
		<div class="modal-content">
		  <h4 class="titleB01">Create New Task</h4>
		  <div class="row">
		  	<div class="col l12 s12 input-field">
		  		<input type="text" id="taskTitle">
		  		<label for="taskTitle">Task Title</label>
		  	</div>
		  	<div class="col l12 s12 input-field">
		  		<textarea id="keterangan" class="materialize-textarea"></textarea>
		  		<label for="keterangan">Comment</label>
		  	</div>
		  </div>
		</div>
		<div class="modal-footer">
		  <a href="#!" class="modal-action modal-close btn btnB01">Cancel</a>
		  <a href="#!" class="modal-action modal-close btn btnB01 mr5" id="createTask">Confirm</a>
		</div>
	</div>

	<!-- Modal Add Task -->
	<div id="modalAddTask" class="modal modal-fixed-footer modal1">
		<div class="modal-content">
		  <h4 class="titleB01">Add New Task</h4>
		  <hr>
		  <div class="row taskList">
		  	<div class="col l12 s12 pad-l-n">
		  		<div class="col l1 s1 input-field pad-l-n">
		  			<input type="checkbox" class="filled-in" id="test">
		  			<label for="test"></label>
		  		</div>
		  		<div class="col l11 s11 pad-l-20">
		  			<p class="red1-text lato-black mb0 titleTask">Test</p>
		  			<p class="mt0 commentTask">sadasdasdasdasdasdasdasdsadasd</p>
		  		</div>
		  	</div>
		  	<div class="col l12 s12 pad-l-n">
		  		<div class="col l1 s1 input-field pad-l-n">
		  			<input type="checkbox" class="filled-in" id="test1">
		  			<label for="test1"></label>
		  		</div>
		  		<div class="col l11 s11 pad-l-20">
		  			<p class="red1-text lato-black mb0 titleTask">Test</p>
		  			<p class="mt0 commentTask">sadasdasdasdasdasdasdasdsadasd</p>
		  		</div>
		  	</div>
		  	<div class="col l12 s12 pad-l-n">
		  		<div class="col l1 s1 input-field pad-l-n">
		  			<input type="checkbox" class="filled-in" id="test3">
		  			<label for="test3"></label>
		  		</div>
		  		<div class="col l11 s11 pad-l-20">
		  			<p class="red1-text lato-black mb0 titleTask">Test</p>
		  			<p class="mt0 commentTask">sadasdasdasdasdasdasdasdsadasd</p>
		  		</div>
		  	</div>
		  	<div class="col l12 s12 pad-l-n">
		  		<div class="col l1 s1 input-field pad-l-n">
		  			<input type="checkbox" class="filled-in" id="test4">
		  			<label for="test4"></label>
		  		</div>
		  		<div class="col l11 s11 pad-l-20">
		  			<p class="red1-text lato-black mb0 titleTask">Test</p>
		  			<p class="mt0 commentTask">sadasdasdasdasdasdasdasdsadasd</p>
		  		</div>
		  	</div>
		  	<div class="col l12 s12 pad-l-n">
		  		<div class="col l1 s1 input-field pad-l-n">
		  			<input type="checkbox" class="filled-in" id="test5">
		  			<label for="test5"></label>
		  		</div>
		  		<div class="col l11 s11 pad-l-20">
		  			<p class="red1-text lato-black mb0 titleTask">Test</p>
		  			<p class="mt0 commentTask">sadasdasdasdasdasdasdasdsadasd</p>
		  		</div>
		  	</div>
		  </div>
		</div>
		<div class="modal-footer">
		  <a href="#!" class="modal-action modal-close btn btnB01">Cancel</a>
		  <a href="#!" class="modal-action modal-close btn btnB01 mr5" id="addTask">Add</a>
		</div>
	</div>

	<!-- Modal Delete -->
	<div id="modalDelete" class="modal modal-fixed-footer modal-confirm">
		<div class="modal-content">
		  <h4 class="titleB01">Delete?</h4>
		  <div class="row">
		  	<div class="col l12 s12 input-field">
		  		<p>Are you sure want to delete this task?</p>
		  	</div>
		  </div>
		</div>
		<div class="modal-footer">
		  <a href="#!" class="modal-action modal-close btn btnB01">No</a>
		  <a href="#!" class="modal-action modal-close btn btnB01 mr5" id="yesDeleteTask">Yes</a>
		</div>
	</div>

	<form id="createTask">
	</form>
 @endsection

@section('customjs')
    <script type="text/javascript">
    $(document).ready(function(){
    	var x = $('.titleTask-input').length;
    	$('#createTask').click(function(){
    		$('ul#task').append(
    			'<li class="relative">' +
					'<p class="lato-black red1-text mb0 titleTask" data-name="input['+ x +'][title]">' + $('#taskTitle').val() + '</p>' +
					'<p class="mt0 grey-text lato-black commentTask" data-name="input['+ x +'][comment]">' + $('#keterangan').val() +  '</p>' +
					'<i class="fa fa-times right absolute top0 right0 cursorPointer deleteTask"></i>' +
				'</li>'
    		);
    		$('form#createTask').append(
    			'<input type="hidden" class="titleTask-input" name="input['+ x +'][title]" value="' + $('#taskTitle').val() +'">' +
    			'<input type="hidden" class="titleComment-input" name="input['+ x +'][comment]" value="' + $('#keterangan').val() + '">'
    		);
    		$('#taskTitle').val('').focus().blur();
    		$('#keterangan').val('').focus().blur();
    		x++;
    	});

    	$('#addTask').click(function(){
    		$('.taskList input:checkbox:checked').each(function(){
    			var title = $(this).closest('.col.l12').find('.titleTask').text();
    			var comment = $(this).closest('.col.l12').find('.commentTask').text();

    			$('ul#task').append(
	    			'<li class="relative">' +
						'<p class="lato-black red1-text mb0 titleTask" data-name="input['+ x +'][title]">' + title + '</p>' +
						'<p class="mt0 grey-text lato-black commentTask" data-name="input['+ x +'][comment]">' + comment +  '</p>' +
						'<i class="fa fa-times right absolute top0 right0 cursorPointer deleteTask"></i>' +
					'</li>'
	    		);
	    		$('form#createTask').append(
	    			'<input type="hidden" class="titleTask-input" name="input['+ x +'][title]" value="' + title +'">' +
	    			'<input type="hidden" class="titleComment-input" name="input['+ x +'][comment]" value="' + comment + '">'
	    		);
    			x++;
    		})
    	})

    	$('body').on('click', '.deleteTask', function(){
    		var parent = $(this).closest('li');
    		var title = parent.find('.titleTask').data('name');
    		var comment = parent.find('.commentTask').data('name');
    		$('#modalDelete').openModal();

    		$('#yesDeleteTask').click(function(){
    			parent.hide(100, function(){ parent.remove()});
    			$('form#createTask').find('input[name="'+ title +'"], input[name="' + comment +'"]').remove();
    		})
    	});
    })
    </script>
@endsection