@extends('layouts.app')
@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
@endsection

@section('customCss')
    {!! Html::style('assets/plugins/dataTable/datatables.min.css')!!}
@endsection
@section('customjs')
    {!! Html::script('assets/plugins/dataTable/datatables.min.js')!!}
    {!! Html::script('assets/js/scriptDataTable.js')!!}
    <script type="text/javascript">

    	function changeList(checked,employeeID){
			var approverList = $('#approver_list').val();
			var id = employeeID + ','; //contoh: '17,'

			if(checked){ //tambahin id ke approver list
				var srch = approverList.indexOf(id);
				if (srch==-1) approverList += id; //else berarti udah ada, gausa diapa2in
			} else { //ilangin id dari approver list
				var arr = approverList.split(id); //split biar id otomatis ilang dari string
				if(!arr[1]) approverList = arr[0]; //if id not found, use arr[0]
				else approverList = arr[0]+arr[1];
			}
			$('#approver_list').val(approverList);
		}
    	$(document).ready(function(){
    		$('#addTimeOff').click(function(){
    			$(document).ajaxSuccess(function(event, xhr, settings){
					// $('#modalAddTimeoff').closeModal();
					if(xhr.responseJSON.url){
		              console.log(xhr.responseJSON.url);
		              window.location.href=xhr.responseJSON.url;
		              location.reload();
		            };
    			})
    		})

    		$('#other').change(function(){
    			if ($(this).is(':checked')) {
					$('#otherEmployeeList').show(100)
    			}
    			else {
    				$('#otherEmployeeList').hide(100)
    			}
    		})


	        $('#otherEmployeeList').on('change','input[type="checkbox"]',function(){
  				var id = $(this).attr('id').slice(15); //id = 'searchEmployee_#'.slice()
				changeList(this.checked,id);
				if ($(this).is(':checked')) {
					$('#otherEmployeeList input[type="checkbox"]:not(:checked)').each(function(){
						$(this).attr('disabled', 'disabled')
					})
				}
				else {
					$('#otherEmployeeList input[type="checkbox"]:not(:checked)').each(function(){
						$(this).removeAttr('disabled')
					})
				}
			});

    		$('#unlimited_flag').change(function(){
    			if ($(this).is(':checked')) {
    				$('#inputBalance').hide();
    			}
    			else {
    				$('#inputBalance').show();
    			}
    		});

    		$('#allEmployee').change(function(){
    			if($(this).is(':checked')) {
    				$('#employeeListWrap input:checkbox').prop('checked', true);
    				// $('#employeeListWrap').hide(300);
    			} else {
    				$('#employeeListWrap input:checkbox').prop('checked', false);
    				// $('#employeeListWrap').show(300);
    			}
    		})

    		$('#employeeListWrap input:checkbox').change(function(){
			    var checkedLength = $('#employeeListWrap input:checkbox:checked').length;
			    if (checkedLength == $('#employeeListWrap input:checkbox').length) {
			      $('#allEmployee').prop('checked', true);
				  // $('#employeeListWrap').hide();
			    } else {
			      $('#allEmployee').prop('checked', false);
			      // $('#employeeListWrap').show();
			    }
    		});

    		// $('#edit-allEmployee').change(function(){
    		// 	if($(this).is(':checked')) {
    		// 		$('#edit-employeeListWrap').hide(300);
    		// 	}
    		// 	else {
    		// 		$('#edit-employeeListWrap').show(300);
    		// 	}
    		// })

    		$('.modal-trigger-request').click(function(){
				var url = $('#timeoffRequestDetailURL').val();
				var id = $(this).attr('id');
		        $.ajax({
		            type:"get",
		            dataType:'json',
		            url: url+'/'+id,
		            success: function (data) {
		            	$('.approvalButton').removeClass('hide'); //TODO: validasi approver apa bukan
		            	$('#modalDR-id').val(data.id);
		            	$('#modalDR-policy').html(data.policy.name);
		            	$('#modalDR-name').html(data.employee.first_name+' '+data.employee.last_name);
		            	$('#modalDR-start').html(data.start_date);
		            	$('#modalDR-end').html(data.end_date);
		            	$('#modalDR-amount').html(data.amount);
		            	$('#modalDR-reason').html(data.reason);
		            	// validasi apakah user == approver
		            	if(data.approver.isApprover == 1){
		            		$('.approvalButton').show();
		            	} else {
		            		$('.approvalButton').hide();
		            	}
		            	var status = 'Waiting approval from <br><ul>';

		            	//loop for each approver
		            	data.approver.list.forEach(function(item,index){
		            		status += '<li>' + item + '</li>';
		            	});
		            	status += '</ul>';
		            	$('#modalDR-status').html(status);
		            	$('#modalDetailRequest').openModal();
		            },
		            error: function(data){
		                console.log('Error :', data);
		            }
		        });
		    })

    		$('.modal-trigger-policy').click(function(){
				var url = $('#timeoffPolicyDetailURL').val();
				var id = $(this).attr('id');
		        $.ajax({
		            type:"get",
		            dataType:'json',
		            url: url+'/'+id,
		            success: function (data) {
		            	$('#modalDP-id').val(data.id);
		            	$('#modalDP-code').html(data.policy_code);
		            	$('#modalDP-name').html(data.name);
		            	$('#modalDP-effdate').html(data.effective_date);
		            	if(data.deleted_at){
		            		$('#modalDP-expdate').html(data.deleted_at);
		            		 $('#deletePolicyBtn').hide();
		            	} else {
		            		$('#modalDP-expdate').html('-');
		            		$('#deletePolicyBtn').show();
		            	}
		            	if (data.unlimited_flag==1) {
		            		$('#modalDP-balance').html('unlimited');
		            	} else {
		            		$('#modalDP-balance').html(data.balance);
		            	}
		            	$('#modalDetailPolicy').openModal();
		            },
		            error: function(data){
		                console.log('Error :', data);
		            }
		        });
		    })

		    $('#yesDeletePolicy').click(function(){
  				$(this).addClass('disabled');
		    	var url = $('#timeoffDeletePolicyURL').val();
		    	var postData = {};
		    	postData['id'] = $('#modalDP-id').val();
		   		$.ajax({
		            type:"post",
		            dataType:'json',
		            url: url,
		            data: postData,
		            success: function (data) {
		            	Materialize.toast('Expire Successfully <i class="fa fa-check ml25"></i>', 3000,'teal')
						$(this).removeClass('disabled');
						window.location.href = data.url;
						window.location.reload();
					},
		            error: function(data){
		                console.log('Error :', data);
		            }
		        });
		    });

			$('.modal-trigger-history').click(function(){
				var url = $('#timeoffHistoryDetailURL').val();
				var id = $(this).attr('id');
		        $.ajax({
		            type:"get",
		            dataType:'json',
		            url: url+'/'+id,
		            success: function (data) {
		            	$('.approvalButton').addClass('hide');
		            	$('#modalDH-id').val(data.id);
		            	$('#modalDH-policy').html(data.policy.name);
		            	$('#modalDH-name').html(data.employee.first_name+' '+data.employee.last_name);
		            	$('#modalDH-date').html(data.date);
		            	$('#modalDH-amount').html(data.day_amount);
			            var status = 'Approved by '+data.approverName+' on '+data.created_date;
		            	$('#modalDH-status').html(status);
		            	$('#modalDetailHistory').openModal();
		            },
		            error: function(data){
		                console.log('Error :', data);
		            }
		        });
		    });

		    $('.deletePolicyIcon').click(function(e){
		    	e.stopPropagation();
		    	var id = $(this).closest('tr').attr('id');
		    	$('#modalDP-id').val(id);
		    	$('#deletePolicyBtn').trigger('click');
		    });

		    $('.editPolicyIcon').click(function(e){
		    	e.stopPropagation();
		    	var id = $(this).closest('tr').attr('id');
		    	$('#createPolicyField').hide();
		    	$('#modalAddTimeoff').find('form').attr('action',"{{route('timeoff.edit.assign')}}");
		    	$('#modalAddTimeoff').find('.titleB01').html('Edit Policy');
		    	$('#modalEP-id').val(id);
    			$('#employeeListWrap input:checkbox').prop('checked',false);
		    	$.ajax({
		    		url:"{{route('timeoff.edit.assign')}}/" + id,
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

				    	$('#modalAddTimeoff').openModal({
							complete: function(){
								$('#createPolicyField').show();
								$('#modalAddTimeoff').find('form').attr('action',"{{route('timeoff.create')}}");
								$('#modalAddTimeoff').find('.titleB01').html('Create New Policy');
							}
						});
		    		}
		    	});
		    });

		    $('.viewBalanceIcon').click(function(e){
		    	e.stopPropagation();
		    	var id = $(this).closest('tr').attr('id');
    	        $.ajax({
		            type:"get",
		            url: "{{route('timeoffbalancelist')}}" + "/" + id,
		            success: function (response) {
		            	$('#tbody-balance').html('');
		              	for(i=0;i<Object.keys(response).length;i++){
		              		var row = $('#tr-balance-template').clone();
		              		row.attr('id','balance-'+response[i].employee_id);
		              		row.find('#modalBalance-name').html(response[i].first_name+" "+response[i].last_name);
		              		row.find('#modalBalance-employeeCode').html(response[i].employee_code);
		              		row.find('#modalBalance-taken').html(response[i].taken);
		              		if(response[i].flag==1){
			              		row.find('#modalBalance-quota').html("&infin;");
			              		// row.find('#modalBalance-balance').html(response[i].quota - response[i].taken);
			              		// row.find('#modalBalance-button').html(response[i].quota - response[i].taken);
			              	} else {
			              		if(response[i].quota) row.find('#modalBalance-quota').html(response[i].quota);
  			              		else row.find('#modalBalance-quota').html('0');
                        row.find('#modalBalance-balance').html(response[i].quota - response[i].taken);
			              		// row.find('#modalBalance-button').html('');
			              	}
		              		$('#tbody-balance').append(row);
		                }
				    	$('#modalBalance-id').val(id);
				    	$('#modalBalance').openModal();
		            },
		            error: function(data){
		                console.log(data);
		            }
		        });
		    });

			/** approve/reject Time Off
			 */
			$('body').on('click','.approvalButton', function(e){
				Materialize.toast('Please wait...', 7000);
				var $this = $(".approvalButton");
				$this.addClass('disabled');
				e.preventDefault();
				var postData = {};
				// var csrfToken = $('meta[name="csrf-token"]').attr("content");
				var approve = $(this).html();
				var url='';
				console.log('approve:'+approve);
				if      (approve == 'Approve') url= $('#timeoffApproveURL').val();
				else if (approve == 'Reject' ) url= $('#timeoffRejectURL').val();
				console.log('url:'+url);
				var reason = '';//$('.inboxReason').val();
				// postData['_csrf'] = csrfToken;
				postData['id'] = $('#modalDR-id').val();
				postData['reason'] = reason;
				$.ajax({
				    type: 'post',
				    url : url,
				    data: postData,
				    dataType:'JSON',
				    success: function (data) {
				      if(data.status == 'approved'){
				        $('#modalDetailRequest').closeModal();
			            $this.removeClass('disabled');
				        Materialize.toast('You have Approved this Time off Request <i class="fa fa-check ml25"></i>', 2000,'teal',function(){
                  location.reload();
                });
				      } else if(data.status == 'rejected'){
				        $('#modalDetailRequest').closeModal();
				        $this.removeClass('disabled');
				        Materialize.toast('You have Rejected this Time off Request <i class="fa fa-check ml25"></i>', 2000,'teal',
                function(){
                  location.reload();
                });
				      }
				    }, error: function (data) {
				       console.log(data);
				       $this.removeClass('disabled');
				    }
				});
			});

			$('#filterBtn').click(function(e){
				e.preventDefault();
				var date = '20'+$('#year').val() +'-'+ $('#month').val();

				var parent = $(this).closest('.row');
				// console.log(parent.next('.row').find("table tbody tr").length);
				// Loop through the table
				parent.next('.row').next('.row').find("table tbody tr").each(function(){
				    // If the list item does not contain the specified date, fade it out
				    var getDate = $(this).find('td:eq(2)').attr('value').slice(0,7);
				    if (getDate != date) {
				        $(this).closest('tr').fadeOut();

				    // Show the list item if the date matches
				    } else {
				        $(this).closest('tr').fadeIn();
				    }
				});// Loop through the table
			});

			$('body').on('click','.editBalance',function(){
				var tdquota = $(this).closest('tr').find('.modalBalance-quota');
				tdquota.html("<input type='text' class='w50' value='"+tdquota.html()+"'>");
				$(this).closest('td').html('<a href="#" class="saveBalance btn btnB01 cursorPointer">Save</a>')
			});

			$('body').on('click','.saveBalance',function(){
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
					url:"{{route('timeoff.edit.balance')}}",
					method:"POST",
					dataType:"JSON",
					data:data,
					success: function(response){
						if(response.status=='success'){
							successMessage = 'Successfully update balance';
							tdquota.html(val);
							tdbalance.html(val-taken);
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
						console.log(response);
					}
				});
			});

    	})
    </script>
@endsection

@section('content')
	<?php
	    if(Sentinel::getUser()->userAccessConnection->employee_id_fk != null){
			$generalHeaderButton = '<a href="#modalRequestTimeOff" class="modal-trigger grey-text lato-bold"><i class="talenta-tambah displayInlineBlock mr5 fa-2x"></i>Request Time Off</a>';
    	}
	?>
	@include('layouts.headers.general')
	<div class="container mt30">
		<input type="hidden" id="timeoffRequestDetailURL" value="{{route('timeoffdetail')}}" >
		<input type="hidden" id="timeoffHistoryDetailURL" value="{{route('timeoffhistorydetail')}}" >
		<input type="hidden" id="timeoffApproveURL" value="{{route('timeoffapprove')}}">
		<input type="hidden" id="timeoffRejectURL" value="{{route('timeoffreject')}}">
		<div class="row">
			<div class="col s12 hide-on-large-only input-field">
				<select class="browser-default tab-selector-mobile">
					<option value="requestlist">Request List</option>
					<option value="history">Timeoff History</option>
					<option value="policy">Timeoff Policy</option>
				</select>
			</div>
			<div class="col s12 hide-on-med-and-down">
				<nav class="nav3 tab3">
			      	<div class="nav-wrapper">
				        <ul id="tabs3">
							<li class="tab text-uppercase ls2 pad-l-n"><a href="#requestlist" class="lato-black f12">Request List</a></li>
							<li class="tab text-uppercase ls2"><a href="#history" class="lato-black f12">Timeoff History</a></li>
							<li class="tab text-uppercase ls2"><a href="#policy" class="lato-black f12">Timeoff Policy</a></li>
						</ul>
			      	</div>
			    </nav>
			</div>
		</div>
		<div id="requestlist" class="tab-content">

			<!-- Pending -->
			<div class="row">
				<div class="col l3 m6 s12">
					<p class="red1-text lato-black f20 mt20">Waiting for approval</p>
				</div>
		      	<div class="col l3 s12 m6 right">
		        	<input type="text" class="search searchLive" placeholder="Search">
		      	</div>
		    </div>
		    <div class="row">
		      <div class="col l12 positionRelative">
		        <div class="w100p maxHeight370 overflowAuto">
		          <table class="table responsive-table">
		            <thead class="grey lighten-3 bold">
						<tr>
							<th>Policy Name</th>
							<th>Employee</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Days Amount</th>
							<th width="100"></th>
						</tr>
		            </thead>
		            <tbody>
		            	@foreach ($requestList['pending'] as $data)

			            	<tr id="{{$data->id}}" class="modal-trigger-request cursorPointer" href="#modalDetailRequest">
			            		<td>{{$data->policy['name']}}</td>
			            		<td>{{$data->employee['first_name'].' '.$data->employee['last_name']}}</td>
			            		<td>{{$data->start_date}}</td>
			            		<td>{{$data->end_date}}</td>
			            		<td>{{$data->amount}}</td>
			            		<td>
			            			<a href="#!" class="linkB01">see details</a>
			            		</td>
			            	</tr>
						@endforeach
		            </tbody>
		          </table>
		        </div>
		      </div>
		    </div>

		</div>

		<div id="policy" class="tab-content">
			<input type="hidden" id="timeoffPolicyDetailURL" value="{{route('timeoffpolicydetail')}}" >
			<input type="hidden" id="timeoffDeletePolicyURL" value="{{route('timeoffdeletepolicy')}}" >
			<div class="row">
				<div class="col l12">
					<div class="disabledWarningDiv">
						<div class="col l1 center-align">
							<img src="assets/images/warning1.png" class="responsive-img">
						</div>
						<div class="col l10">
							<p>Warning: Time off policy(s) that has been created cannot be edited in regards to its effect and complications its records. If you need to make changes, you can do so by creating new time off policy.</p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<!--
				<div class="col l12 m12 s12">
					<a href="#modalAddTimeoff" class="btnEmployeeIndex h100 col l2 m2 s6 pad-t-10 modal-trigger">
			            <i class="talenta-tambah"></i>
			            Create<br>Time Off
			        </a>
			        <a href="#!" class="btnEmployeeIndex h100 col l2 m2 s6 pad-t-10">
			            <i class="talenta-tambah"></i>
			            View<br>Setting
			        </a>
					<div class="col l4 m4 s12 btnEmployeeIndex attendanceBox pad-t-20 pad-b-20 h100">
						<p class="subtitleA01 white-text">Assigning Time Off</p>
						<a href="#!" class="btnB01">Download</a>
						<a href="#!" class="btnB01">Import</a>
					</div>
					<div class="col l4 m4 s12 btnEmployeeIndex attendanceBox pad-t-20 pad-b-20 h100">
						<p class="subtitleA01 white-text">update balance</p>
						<a href="#!" class="btnB01">Download</a>
						<a href="#!" class="btnB01">Import</a>
					</div>
				</div>
					-->
				<div class="col l3 m6 s12 pad-t-20">
					<a href="#modalAddTimeoff" class="modal-trigger grey-text lato-bold"><i class="talenta-tambah displayInlineBlock mr5 fa-2x"></i>Add New Policy</a>
				</div>
		      	<div class="col l3 s12 m6 right">
		        	<input type="text" class="search" placeholder="Search" id="searchLive">
		      	</div>
			</div>

			<div class="row">
				<div class="col l12 m12 s12">
					<table class="table responsive-table">
						<thead class="grey lighten-3 bold">
							<tr>
								<td width="70">Code</td>
								<td>Name</td>
								<td>Effective Date</td>
								<td>Expired Date</td>
								<td>Valid for</td>
								<td>Action</td>
							</tr>
						</thead>
						<tbody>
		            @foreach($list as $data)
            			<tr id="{{$data['id']}}" class="modal-trigger-policy cursorPointer" href="#modalDetailPolicy">
								<td><a href="#!" class="red1-text bold">{{$data['policy_code']}}</a></td>
								<td>{{$data['name']}}</td>
								<td>{{$data['effective_date']}}</td>
								<td>
									@if($data['deleted_at'])
										{{$data['deleted_at']}}
									@else
										-
									@endif
								</td>
								<td>All Employee</td>
								<td>
									<a href="#!"
									class="viewBalanceIcon red1-text bold"
									data-tooltip="View Balance By Employee"><i class="fa fa-user mr5"></i></a>
									@if ($data['deleted_at']==null)
									<a href="#!" class="editPolicyIcon red1-text bold" data-tooltip="Edit Policy"><i class="fa fa-gear mr5"></i></a>
									<a href="#!" class="deletePolicyIcon red1-text bold" data-tooltip="Expire Policy"><i class="fa fa-times mr5"></i></a>
									@endif

								</td>
				         </tr>
               		@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div id="history" class="tab-content">

			<!-- select period -->
			<!-- <div class="col l3 m6 s12"> -->
			<div class="row">
				<!-- <form action="{{route('timeoffhistory')}}"> -->
				<!-- <form action="#"> -->
				<form>
					<input id="filterURL" type="hidden" value="{{route('timeoffhistory')}}">
					<div class="col l1 s4 input-field">
						<select id="month">
							<option value="01">Jan</option>
							<option value="02">Feb</option>
							<option value="03">Mar</option>
							<option value="04">Apr</option>
							<option value="05">May</option>
							<option value="06">Jun</option>
							<option value="07">Jul</option>
							<option value="08">Aug</option>
							<option value="09">Sep</option>
							<option value="10">Oct</option>
							<option value="11">Nov</option>
							<option value="12">Dec</option>
						</select>
					</div>
					<div class="col l1 s4 input-field">
						<select id="year">
							<option value="01">2001</option>
							<option value="02">2002</option>
							<option value="03">2003</option>
							<option value="04">2004</option>
							<option value="05">2005</option>
							<option value="06">2006</option>
							<option value="07">2007</option>
							<option value="08">2008</option>
							<option value="09">2009</option>
							<option value="10">2010</option>
							<option value="11">2011</option>
							<option value="12">2012</option>
							<option value="13">2013</option>
							<option value="14">2014</option>
							<option value="15">2015</option>
							<option value="16">2016</option>
						</select>
					</div>
					<div class="col l1">
						<button id="filterBtn" class="btn btnB01 mt20">Filter</button>
					</div>
				</form>
			</div>


		    <!-- Approved -->
		    <div class="row">
				<div class="col l3 m6 s12">
					<p class="red1-text lato-black f20 mt20">Time Off History</p>
				</div>

		      	<div class="col l3 s12 m6 right">
		        	<input type="text" class="search searchLive" placeholder="Search">
		      	</div>
		    </div>

		    <div class="row">
		      <div class="col l12 positionRelative">
		        <div class="w100p maxHeight370 overflowAuto">
		          <table class="table responsive-table">
		            <thead class="grey lighten-3 bold">
						<tr>
							<th>Policy Name</th>
							<th>Employee</th>
							<th>Date</th>
							<th>Day Amount</th>
							<th width="100"></th>
						</tr>
		            </thead>
		            <tbody>
		            	@foreach ($requestList['history'] as $data)
			            	<tr id="{{$data->id}}" class="modal-trigger-history cursorPointer" href="#modalDetailRequest">
			            		<td>{{$data->policy['name']}}</td>
			            		<td>{{$data->employee['first_name'].' '.$data->employee['last_name']}}</td>
			            		<td value="{{$data->date}}">{{$data->dateF}}</td>
			            		<td>{{$data->day_amount}} day</td>
			            		<td>
			            			<a class="linkB01">see details</a>
			            		</td>
			            	</tr>
						@endforeach
		            </tbody>
		          </table>
		        </div>
		      </div>
		    </div>
		</div>

	</div>

	@include('timeoff/partials/create-policy-modal')
	@include('timeoff/partials/detail-request-modal')
	@include('timeoff/partials/detail-history-modal')
	@include('timeoff/partials/detail-policy-modal')
	@include('timeoff/partials/balance-modal')








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

	@include('timeoff/request-modal')
	@include('reimbursement/partials/delete-policy-modal')
@endsection
