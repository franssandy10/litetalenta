@extends('layouts.app')

@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
@endsection
@section('url-ajax')
<input id="url_get_city" type="hidden" value="{{url('services/get-city')}}" />
@endsection('url-ajax')
@section('customCss')
	{!! Html::style('assets/plugins/dataTable/datatables.min.css')!!}
	{!! Html::style('assets/css/style-setting.css')!!}
@endsection
@include('setting/company-info/detail')
@include('setting/company-info/department')
@include('setting/company-info/job-position')
@section('customjs')
	{!! Html::script('assets/plugins/dataTable/datatables.min.js')!!}
	{!! Html::script('assets/js/scriptDataTable.js')!!}
	{!! Html::script('assets/plugins/nestedSortable/jquery.mjs.nestedSortable.js')!!}
	<script type="text/javascript">
		function validateForm2($form, type){
			var button = $form.find('.btnB01');
			button.addClass('disabled');
			$.ajax({
				url:$form.attr('action'),
				method:"POST",
				dataType:'JSON',
				data:$form.serializeArray(),
				success:function(data){
          console.log(data);
          console.log("test");
					if(data.status=='success'){
							deleteToast()
							setTimeout(function(){
								Materialize.toast($form.find('.text_success').val()+'<i class="fa fa-check ml25"></i>', 3000,'teal');
								addTree($form, data, type);
								button.removeClass('disabled');
							},350)
					}
					else{
						button.removeClass('disabled')
						$.each(data,function(x,y){
							deleteToast()
							setTimeout(function(){
								$(".inputTree").addClass('invalid');
								$.each(y,function(a,b){
									Materialize.toast(b+' <i class="fa fa-times ml25"></i>', 3000,'red accent-4');
								});
							}, 350)
						})
					}
				},
				error:function(data){
					console.log(data);
				}
			});
		}

		function addTree(form, data, type) {
			var $this = form.find('.saveTree');
			var parent = $this.closest('.tab-content');
			var nilai = parent.find('.inputTree').val();
			var parentTree = parent.find('select.selectParent').val();
			if (type == 'job') {
				var url = "{{route('setting.job.delete')}}"
			}
			else {
				var url = "{{route('setting.department.delete')}}"
			}

			content = template(data, type, nilai, url);

			if (parentTree) {
				var check = parent.find('.tree li[data-value="' + parentTree + '"] ul:first').length;
				if (check == 0) {
					parent.find('.tree li[data-value="' + parentTree + '"]').append('<ul>' + content + '</ul>');
				}
				else {
					parent.find('.tree li[data-value="' + parentTree + '"] ul:first').append(content);
				}
			}
			else {
				parent.find('.tree').append(content);
			}
			parent.find('.tree li.displayNone').fadeIn(300);
			parent.find('select.selectParent').append('<option value="' + data.id + '">' + nilai + '</option>').material_select();
			parent.find('select.selectParent, .inputTree').val('');
			parent.find('select.selectParent').material_select();
			list.nestedSortable('refresh');
		}

		function template(data, type, nilai, url){
			content = 		'<li class="displayNone" id="' + type + '_' + data.id + '" data-value="' + data.id + '">' +
				    				'<span><name>' + nilai + '<name>' +
					    				'<a href="#!" class="ml5 editName" data-name="' + nilai + '" data-type="' + type + '" data-id="' + data.id + '" data-url="' + url + '" data-tooltip="Edit this Node">' +
					    					'<i class="fa fa-pencil-square-o red1-text"></i>' +
					    				'</a>' +
					    				'<a href="#!" data-url="' + url + '" data-tooltip="Delete this Node" data-id="' + data.id + '" class="deleteJobDepartement">' +
					    					'<i class="fa fa-trash red1-text"></i>' +
					    				'</a>' +
				    				'</span>' +
				    				'<ul></ul>' +
				    			'</li>' ;
			return content;
		}

		$(document).ready(function(){

			list = $('#list_structure_organization, #list_job_position').nestedSortable({
	            handle: 'name',
	            items: 'li',
	            toleranceElement: '> span',
	            listType: 'ul',
	            placeholder: "ui-state-highlight",
	            update: function(event, ui){
	            	var things = ui.item.attr('data-value');
	            	var newParent = ui.item.closest('ul').parent().attr('data-value');
	            	var type = ui.item.attr('data-type');
	            	console.log(things + 'to : ' + newParent);
	            	if (type == 'job') {
						var url = "{{route('setting.job.update')}}"
					}
					else {
						var url = "{{route('setting.department.update')}}"
					}
	            	$.ajax({
	            		url: url,
	            		method: 'POST',
	            		dataType: 'JSON',
	            		data: {id: things, parent_id_fk: newParent},
	            		success: function(data){
	            			//console.log(data);
	            		},
	            		error: function(data){
	            			//console.log('error' + data);
	            		}
	            	})
	            }
	        });

			$('.saveTree').click(function(){
				$form = $(this).parents('form');
				type  = $form.attr('data-type');
			    validateForm2($form, type);
			    Materialize.toast('Saving...', 999999 , 'savingToast');
			});

			$('body').on('click', '.deleteJobDepartement', function(){
				var url = $(this).attr('data-url');
				var id = $(this).attr('data-id');
				parent = $(this).closest('li');
				$('#modalDeleteJobAndDepartement').openModal();
				$('#modalDeleteJobAndDepartement #yesDeleteJobDept').attr({'data-url': url, 'data-id': id});
				console.log(parent.find('ul:first').html())
			})

			$('body').on('click', '.editName', function(){
				var name = $(this).attr('data-name');
				var id = $(this).attr('data-id');
				var url = $(this).attr('data-url');
				var type = $(this).attr('data-type');
				$('#modalUpdateJobAndDepartement').openModal();
				$('#modalUpdateJobAndDepartement #newName').val(name).attr({'data-id': id, 'data-url': url, 'data-type': type}).select();
			});

			$('#yesUpdateJobDept').click(function(){
				var url 	= $('#modalUpdateJobAndDepartement #newName').attr('data-url');
				var id 		= $('#modalUpdateJobAndDepartement #newName').attr('data-id');
				var value 	= $('#modalUpdateJobAndDepartement #newName').val();
				var type	= $('#modalUpdateJobAndDepartement #newName').attr('data-type');
				Materialize.toast('Updating... <i class="fa fa-check ml25"></i>', 3000,'savingToast');
				$.ajax({
					url: url,
					method: 'POST',
					dataType: 'JSON',
					data: {id: id, name: value},
					success: function(data){
						console.log(data);
            if(data.status=='success'){
              deleteToast()
              setTimeout(function(){
                Materialize.toast('Updated <i class="fa fa-check ml25"></i>', 3000,'teal');
                $('#' + type + '_' + id + ' .editName:first').attr('data-name', value)
                $('#' + type + '_' + id + ' name:first').fadeOut(500, function() {
                      $(this).text(value).fadeIn(500);
                  });
              }, 300)
            }
            else{
  						$.each(data,function(x,y){
  							deleteToast()
  							setTimeout(function(){
  								// $(".inputTree").addClass('invalid');
  								$.each(y,function(a,b){
  									Materialize.toast(b+' <i class="fa fa-times ml25"></i>', 3000,'red accent-4');
  								});
  							}, 350)
  						})
  					}

					},
					error: function(data){
						console.log('error' + data)
					}
				})
			});

			$('#yesDeleteJobDept').click(function(){
				var url = $(this).attr('data-url');
				var id = $(this).attr('data-id');
				var parentTab = parent.closest('.tab-content');
				Materialize.toast('Deleting...', 999999 , 'savingToast');
				console.log(parent.find('ul:first').html())
				$.ajax({
					url: url,
					data: {id: id},
					dataType: 'JSON',
					method: 'POST',
					success: function(data){
						deleteToast()
						var temp = parent.find('ul:first').html();

						parentTab.find('select.selectParent option[value="' + id + '"]').remove();
						parentTab.find('select.selectParent').material_select();
						parent.hide(300);
						setTimeout(function(){
							Materialize.toast(data.status + ' <i class="fa fa-check ml25"></i>', 3000,'teal');
							parent.closest('ul').prepend(temp);
							parent.remove();
						}, 350)
					},
					error: function(data){
						deleteToast()
						Materialize.toast(data.status +' <i class="fa fa-times ml25"></i>', 3000,'red accent-4');
						console.log(data);
					}
				})
			})
		})
	</script>
  @yield('detailjs')
@endsection

@section('content')
	@include('layouts.navbars.header-setting')
	<div class="container">
		<div class="row h-tabRow">
		    <div class="col l2 pad-r-n pad-l-n">
		      <ul class="tabs tab-horizontal">
		        <li class="tab col l12"><a href="#company-detail"><i class="talenta-profil-setting fa-3x mb20"></i>Company<br>detail</a></li>
		        <li class="tab col l12"><a href="#department"><i class="talenta-organisasi-setting fa-3x mb20"></i>department</a></li>
		        <li class="tab col l12"><a href="#jobPos"><i class="talenta-dasi fa-3x mb20"></i>job<br>position</a></li>
		        <li class="tab col l12"><a href="#accessRole"><i class="talenta-akses-setting fa-3x mb20"></i>access role</a></li>
		      </ul>
		    </div>

		    <!-- tab-content -->
		    <div class="col l10 white pad-l-n h-tabRow">

        @yield('companyDetailHtml')
		@yield('departmentHtml')
        @yield('jobpositionHtml')
			    <!-- Access Role -->
			    <div id="accessRole" class="col l12 pad-20 tab-content">
			    	<div class="row">
			    		<p class="titleB01">Access Role</p>
			    		<hr class="mt10 mb20">
		    			<div class="col l12">
			    			<table class="bordered dataTable w100p">
			    				<thead class="grey lighten-3 bold">
			    					<tr>
			    						<td>Role Name</td>
			    						<td>Action</td>
			    					</tr>
			    				</thead>
			    				<tbody>
			    					<tr>
			    						<td>Admin (default)</td>
			    						<td><a href="#!" class="bold red1-text" data-tooltip="Edit this role"><i class="fa fa-edit"></i></a> &nbsp; <a href="#!" class="bold red1-text" data-tooltip="Delete this role"><i class="fa fa-trash"></i></a></td>

			    					</tr>
			    				</tbody>
			    			</table>
			    		</div>

			    	</div>
			    </div>
		    </div>
		</div>
	</div>

	 <!-- Modal Delete -->
	<div id="modalDeleteJobAndDepartement" class="modal modal-fixed-footer modal-confirm">
		<div class="modal-content">
		  <h4 class="titleB01">Delete?</h4>
		  <div class="row">
		    <div class="col l12 s12 input-field">
		      <p>Are you sure want to delete this?</p>
		    </div>
		  </div>
		</div>
		<div class="modal-footer">
		  <a href="#!" class="modal-action modal-close btn btnB01">No</a>
		  <a href="#!" class="modal-action modal-close btn btnB01 mr5" id="yesDeleteJobDept">Yes</a>
		</div>
	</div>

	<!-- Modal Update Name -->
	<div id="modalUpdateJobAndDepartement" class="modal modal-fixed-footer modal-confirm">
		<div class="modal-content">
		  <h4 class="titleB01">Rename</h4>
		  <div class="row">
		    <div class="col l12 s12 input-field">
		      <input type="text" id="newName">
		      <label for="newName">New Name</label>
		    </div>
		  </div>
		</div>
		<div class="modal-footer">
		  <a href="#!" class="modal-action modal-close btn btnB01">Cancel</a>
		  <a href="#!" class="modal-action modal-close btn btnB01 mr5" id="yesUpdateJobDept">Save</a>
		</div>
	</div>
@endsection
