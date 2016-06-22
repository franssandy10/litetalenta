@extends('layouts.app')

@include('reimbursement/partials/list-policy')
@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
@endsection

@section('customCss')
@endsection
@section('content')
	<?php
		/*$generalHeaderButton = 'Request Reimbursement';
		$generalHeaderLink = '#modalRequestReimbursement';
		$generalButtonClass = 'modal-trigger';*/

    if(Sentinel::getUser()->userAccessConnection->employee_id_fk != null){
      $generalHeaderButton = '<a href="#modalRequestReimbursement" class="modal-trigger grey-text lato-bold"><i class="talenta-tambah displayInlineBlock mr5 fa-2x"></i>Request Reimbursement</a>';
    }
	?>
	@include('layouts.headers.general')
	<div class="container mt30">
		<div class="row">
			<div class="col s12 hide-on-large-only input-field">
				<select class="browser-default tab-selector-mobile">
					<option value="claimlist">Claim List</option>
					<option value="policy">Reimbursement Policy</option>
					<option value="balancelist">Balance</option>
				</select>
			</div>
			<div class="col s12 hide-on-med-and-down">
				<nav class="nav3 tab3">
			      	<div class="nav-wrapper">
			        <ul id="tabs3">
						<li class="tab text-uppercase ls2"><a href="#claimlist" class="lato-black f12">Claim List</a></li>
						<li class="tab text-uppercase ls2"><a href="#policy" class="lato-black f12">Reimbursement Policy</a></li>
						<!-- <li class="tab text-uppercase ls2"><a href="#balancelist" class="lato-black f12">Balance</a></li> -->
					</ul>
			      	</div>
			    </nav>
			</div>
		</div>

    	<div id="claimlist" class="tab-content">
			<div class="row">
				<form>
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
			@include('reimbursement/partials/list-wait')
		    @include('reimbursement/partials/list-claim')
		</div>
    	@yield('listpolicyHtml')
	</div>
	<!-- Modal Delete -->
	@include('reimbursement/partials/create-policy-modal')
	@include('reimbursement/partials/detail-policy-modal')
	@include('reimbursement/partials/detail-request-modal')
	@include('reimbursement/request-modal')
	@include('reimbursement/partials/delete-policy-modal')

@endsection


@section('customjs')
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

  			/* trigger modal for 'waiting request claim' AND 'approved claim'
  			*/
    		$('.modal-trigger-request, .modal-trigger-history').click(function(){
    			var requesttype = $(this).attr('class').indexOf('modal-trigger-request');
    			if (requesttype<0){
					var url = $('#reimbursementHistoryDetailURL').val();
					requesttype = 'taken';
    			} else {
    				var url = $('#reimbursementRequestDetailURL').val();
    				requesttype = 'pending';
    			}

				var id = $(this).attr('id');
				var data = {};
				data['id'] = id;
		        $.ajax({
		            type:"get",
		            dataType:'json',
		            data:data,
		            url: url,
		            // url: url+'/'+id,
		            success: function (data) {
		            	$('#modalDC-id').val(data.id);
		            	$('#modalDC-policy').html(data.policyName);
		            	$('#modalDC-name').html(data.employeeName);
		            	$('#modalDC-amount').html(data.amount);
		            	$('#modalDC-requestdate').html(data.created_date);
		            	if(requesttype == 'taken'){
			            	$('.approvalButton').hide();
			            	$('#modalDC-reason').hide();
			            	var status = 'Approved by '+data.approverName+' on '+data.date_reimburse;
			            } else {
			            	// validasi apakah user == approver
			            	if(data.approver.isApprover == 1){
			            		$('.approvalButton').show();
			            	} else {
			            		$('.approvalButton').hide();
			            	}
			            	$('#modalDC-reason').show();
			            	$('#modalDC-reason').html(data.reason);
			            	var status = 'Waiting approval from <br><ul>';

			            	//loop for each approver
			            	data.approver.list.forEach(function(item,index){
			            		status += '<li>' + item + '</li>';
			            	});
			            	status += '</ul>';
			            }
		            	$('#modalDC-status').html(status);
		            	$('#modalDC-attachment').attr('href',data.attachment);
		            	$('#modalDetailClaim').openModal();
		            },
		            error: function(data){
		                console.log('Error :', data);
		            }
		        });
		    })


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
				if      (approve == 'Approve') url= $('#reimbursementApproveURL').val();
				else if (approve == 'Reject' ) url= $('#reimbursementRejectURL').val();
				var reason = '';//$('.inboxReason').val();
				// postData['_csrf'] = csrfToken;
				postData['id'] = $('#modalDC-id').val();
				postData['reason'] = reason;
				$.ajax({
				    type: 'post',
				    url : url,
				    data: postData,
				    dataType:'JSON',
				    success: function (data) {
				      if(data.status == 'approved'){
				        $('#modalDetailClaim').closeModal();
			            $this.removeClass('disabled');
				        Materialize.toast('You have Approved this Time off Request <i class="fa fa-check ml25"></i>', 2000,'teal');
				      } else if(data.status == 'rejected'){
				        $('#modalDetailClaim').closeModal();
				        $this.removeClass('disabled');
				        Materialize.toast('You have Rejected this Time off Request <i class="fa fa-check ml25"></i>', 2000,'teal');
				      }
				    }, error: function (data) {
				       console.log(data);
				       $this.removeClass('disabled');
				    }
				});
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

  			$('#other').change(function(){

  				//toggle show/hide
  				$('#otherEmployeeList').slideToggle(200);

  				//uncheck other employee
  				if(this.checked==false){
  					//uncheck all checkbox
					$('#otherEmployeeList input:checkbox').prop('checked', false);

					//remove approver list from other employees
  					var userID = $('#userID').val() + ',';
					var list = $('#approver_list').val();
  					if(list.indexOf(userID)==-1) { //kalo "You" unchecked
	  					$('#approver_list').val('');
	  				}
  					else { //"You" checked
  						$('#approver_list').val(userID); //apus smua kcuali userID
  					}
  				}
  			});

  			$('#addReimbursement').click(function(){
			    $form=$(this).parents('form');
    			var button = $form.find('.btnB01');
				button.addClass('disabled');
				unmask();
				$.ajax({
					url:$form.attr('action'),
					method:"POST",
					dataType:'JSON',
					data:$form.serializeArray(),
					success:function(data){
						console.log("success");
						if(data.status == 'success') {
							Materialize.toast($form.find('.text_success').val()+' <i class="fa fa-times ml25"></i>', 3000,'teal');
							window.location.href= data.url;
							window.location.reload();
						}
					},
					error:function(data) {						
						button.removeClass('disabled');
						$.each(data.responseJSON,function(x,y){
							$("#"+x).addClass('invalid');
							Materialize.toast(y+' <i class="fa fa-times ml25"></i>', 3000,'red accent-4');
						});
					}
				});
    		});

  			$('#tabs').tabs()
  			$('div.indicator').remove()

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

			$('#you').change(function(){
				userID = $('#userID').val();
				changeList(this.checked,userID);
			});


			$('#filterBtn').click(function(e){
				e.preventDefault();
				var date = $('#year').val() +'-'+ $('#month').val();
				var parent = $(this).closest('.row');
				// console.log(parent.next('.row').find("table tbody tr").length);
				// Loop through the table
				parent.next('.row').next('.row').find("table tbody tr").each(function(){
				    // If the list item does not contain the specified date, fade it out
				    var getDate = $(this).find('td:eq(2)').attr('value').slice(2,7);
				    if (getDate != date) {
				        $(this).closest('tr').fadeOut();

				    // Show the list item if the date matches
				    } else {
				        $(this).closest('tr').fadeIn();
				    }
				});// Loop through the table
			});

      // for approval
			// $('.modal-trigger').click(function(){
      //
		  //     // dismissible: true, // Modal can be dismissed by clicking outside of the modal
		  //     // opacity: .5, // Opacity of modal background
		  //     // in_duration: 300, // Transition in duration
		  //     // out_duration: 200, // Transition out duration
		  //     // // ready: function() { // Callback for Modal open
		  //     // // },
		  //     // complete: function() { // Callback for Modal close
		  //     	$('#otherEmployeeList input:checkbox').prop('checked', false);
			// 	$('#approver_list').val( $('#userID').val() + ',');
			// 	$('select#limit_type').val(1).trigger('change');
			// 	// $('#limit_type').children(':first').attr('selected','selected');
		  //     // }
		  //   });

        $('#unlimited_flag').change(function(){
          if ($(this).is(':checked')) {
            $('#inputBalance').hide(200);
          }
          else {
            $('#inputBalance').show(200);
          }
        });
  		})
  	</script>
	@yield('requestjs')
    @yield('policyjs')
@endsection
