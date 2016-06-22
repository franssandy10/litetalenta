$(document).ready(function(){

    /**
     *  cek sekaligus menghitung jumlah pesan baru, dan munculkan sebagai notification
     */
    var checkNotif = function () {
        url = $('#tabmessagenotifURL').val();
        $.ajax({
            type:"get",
            url: url,
            success: function (data) {
              	var count=0;
                for(i=1;i<=Object.keys(data).length;i++){ // kalo message-box nya banyak
                    var pnt = $('#'+i).find('span');
                    if(data[i]>0) {
                        pnt.html(data[i]);
                        pnt.css("display","inline");
                        count+=parseInt(data[i]);
                    } else pnt.css("display","none");
                }
                if(count>0) {
                    $(".notifIcon").html(count);
                    $(".notifIcon").show();
                    $('#1').find('span').html(count);
                    $('#1').find('span').css("display","inline");
                } else {
                    $(".notifIcon").hide();
                    $('#1').find('span').css("display","none");
                }
            },
            error: function(data){
                console.log('Error checkNotif:', data);
            }
        });
    }

    /**
     *  Custom date formatting
     *  type 0: 2016-03-30 05:15
     *  type 1: 2016-03-30
     */
    function formatDate (date,type) {
      var YYYY = date.substr(0,4);
      var MM = date.substr(5,2);
      var DD = date.substr(8,2);
      var HHMM = date.substr(11,5);
      var month='not set';

      switch (type) {
        case 'DD Month YYYY HH:MM':
            m_jan='January';
            m_feb='February';
            m_mar='March';
            m_apr='April';
            m_may='May';
            m_jun='June';
            m_jul='July';
            m_aug='August';
            m_sep='September';
            m_oct='October';
            m_nov='November';
            m_dec='December';
            break;
        case 'DD Month YYYY HH:MM indo':
            m_jan='Januari';
            m_feb='Februari';
            m_mar='Maret';
            m_apr='April';
            m_may='Mei';
            m_jun='Juni';
            m_jul='Juli';
            m_aug='Agustus';
            m_sep='September';
            m_oct='Oktober';
            m_nov='November';
            m_dec='Desember';
            break;
        case 'DD Mon YYYY HH:MM':
            m_jan='Jan';
            m_feb='Feb';
            m_mar='Mar';
            m_apr='Apr';
            m_may='May';
            m_jun='Jun';
            m_jul='Jul';
            m_aug='Aug';
            m_sep='Sep';
            m_oct='Oct';
            m_nov='Nov';
            m_dec='Dec';
            break;
        default: month='month type error';
      }

      switch (MM) {
        case '01': month=m_jan; break;
        case '02': month=m_feb; break;
        case '03': month=m_mar; break;
        case '04': month=m_apr; break;
        case '05': month=m_may; break;
        case '06': month=m_jun; break;
        case '07': month=m_jul; break;
        case '08': month=m_aug; break;
        case '09': month=m_sep; break;
        case '10': month=m_oct; break;
        case '11': month=m_nov; break;
        case '12': month=m_dec; break;
        default: month='month error';
      }
      return DD+' '+month+' '+YYYY+', '+HHMM;
    }


    /**
     *  tampilkan daftar pesan yang sudah di-load
     *  @param json(data) = data pesan-pesan yang sudah di-load
     */
	  //// TO-DO : lom di tes kalo inbox kosong, TO-DO: blom ada indikator approved/rejected di list
    var showMessage = function (data){

      if (data.length != 0) {
        $('#checkAllInbox').prop('checked', false);
        checkNotif();
        var msg = '<ul id="MessageContainer" class="collection">';
        var nama='';
        for (i = 0; i < data.length; i++) {
          console.log(data);
          if (data[i].sender) nama = data[i].sender.name; //if not null
          else nama = data[i].receiver.name;
          // if (data[i].displayname) nama = data[i].displayname; //if not null
          // else nama = data[i].sender + " to " + data[i].receiver;

          msg +=  '<li class="collection-item avatar" title="Click To Read" id='+data[i].id+' data-target="#!">';
          msg +=    '<p>';
          msg +=      '<input type="checkbox" class="filled-in  inboxCheckToggleRead" id="test" name="inboxCheck" value="'+data[i].id+'">';
          msg +=      '<label for="messageCheck_'+i+'" class="dashboard-leave black-text"></label>';
          msg +=    '</p>';
          msg +=    '<p class="w50p floatNone ml35 black-text mtm30 truncate">'+nama;

          if (data[i].is_read==0 && data[i].sender)
          {
            msg+=' <span class="new badge lato-bold mtm3 bgRed1 bold relative ml15"></span>';
          }
          msg +=    '</p>';
          msg +=    '<p class="w50p floatNone ml35 black-text mt5 truncate';

          if (!data[i].is_read) {
            msg+= 'bold';
          }
          msg +=       '">'+data[i].subject+'</p>';
          msg +=    '<span class="secondary-content bold hide-on-small-only">'+ formatDate(data[i].created_at,'DD Month YYYY HH:MM indo') +'</span>';
          msg +=    '<span class="secondary-content bold hide-on-med-and-up">'+ formatDate(data[i].created_at,'DD Mon YYYY HH:MM') +'</span>';
          msg += '</li>';

        }

        msg +=  '</ul>';
      }
      else {
        msg = '<ul id="MessageContainer" class="collection">' +
                '<li class="collection-item">' +
                    '<div class="col l12 center-align">' +
                      '<i class="fa fa-inbox fa-4x"></i>' +
                      '<h5 class="noMessage">You don‘t have any message right now.</h5>' +
                    '</div>' +
                '</li>'
              '</ul>';
      }
      $("#MessageContainer").replaceWith( msg );
    }

    /**
      * Function retrieve boxType
      * 0=Sent Item; 1=Inbox
      */
    function getBoxType() {
        return $('.tab-horizontal').find(".active").closest('li').attr('id');
    }

    /**
     *  Function untuk REFRESH List menggunakan AJAX
     *  @param string searchKey = kata kunci untuk searching (opsional)
     */
    function refreshList(searchKey){
        searchKey = searchKey || "";
        var boxType = getBoxType();
        var url = $('.h-tabRow').find('#tabInboxURL').val();
        $.ajax({
            type: "GET",
            url: url +'/'+boxType+'/'+searchKey,
            dataType:'JSON',
            success: function (data) {
                showMessage(data);
            },error: function (data) {
                console.log('Error:', data);
            }
        });
    }


    /** reply message
    */
    $('#readReplyButton').click(function(){
        $('#messageModal').find('#replyPopup').show();
        var subject = $('#readSubject').html();
        if (subject.substr(0,4) != 'Re: ') subject = 'Re: '.concat(subject);
        $('#readReplySubject').val(subject);
    });

    /**
      Fungsi click untuk select-all, select-read, select-unread, unselect-all
    */
  	$('#selectUnread, #selectRead, #selectAll, #unselectAll').click(function(){
  		var status = $(this).attr('id');
      if (!$('#checkAllInbox').is(':checked')) {
    			$('#checkAllInbox').prop('checked', true);
    			$('#dropdownInbox').show(100);
  		};
  		if (status == "selectUnread" && status != 'selectRead' && status != 'selectAll' && status != "unselectAll") {
  			$('.inboxCheckToggleUnread').prop('checked', true);
  			$('.inboxCheckToggleRead').prop('checked', false);
  		}
  		else if (status == "selectRead" && status != 'selectUnread' && status != 'selectAll' && status != "unselectAll") {
  			$('.inboxCheckToggleUnread').prop('checked', false);
  			$('.inboxCheckToggleRead').prop('checked', true);
  		}
  		else if (status == "selectAll" && status != 'selectRead' && status != 'selectUnread' && status != "unselectAll") {
  			$('.inboxCheckToggleUnread, .inboxCheckToggleRead').prop('checked', true);
  		}
  		else if (status == "unselectAll" && status != "selectAll" && status != 'selectRead' && status != 'selectUnread') {
  			$('#checkAllInbox').prop('checked', false);
  			$('.inboxCheckToggleUnread, .inboxCheckToggleRead').prop('checked', false);
  		}
  	});

  /** update tulisan "Select All" ketika di-klik
   */
  $('#inbox-receiver_id').change(function(){
    $('input.select-dropdown').val($( 'option:selected', this).text());
  });

  /** check all inbox
   */
  $('#checkregion').on('click','#checkAllInboxLabel',function(event){
    event.stopPropagation();
    $(this).prev('input[type="checkbox"]').trigger('click');
  });
  $('#checkregion').on('click','i',function(ev){
    ev.stopPropagation();
  });

  /** untuk checkbox di masing2 pesan
  */
	$('#forAjax').on('click','label',function(event){
		event.stopPropagation();
		$(this).prev('input[type="checkbox"]').trigger('click');
	});
	$('#forAjax').on('click','input.filled-in',function(ev){
		if (!$(this).is(':checked')) $('#checkAllInbox').prop('checked', false);
		ev.stopPropagation();
	});

  /** trigger untuk check/uncheck all message
  */
	$('#checkregion').on('click','input.filled-in',function(ev){
		if ($('#checkAllInbox').is(':checked')) {
		// if (status == "selectAll" && status != 'selectRead' && status != 'selectUnread' && status != "unselectAll") {
			$('.inboxCheckToggleUnread, .inboxCheckToggleRead').prop('checked', true);
		}
		else { //if (status == "unselectAll" && status != "selectAll" && status != 'selectRead' && status != 'selectUnread') {
			$('#checkAllInbox').prop('checked', false);
			$('.inboxCheckToggleUnread, .inboxCheckToggleRead').prop('checked', false);
		}
		ev.stopPropagation();
		$('#dropdownInbox').hide(100);
	});

  /** eksekusi delete multiple message
  */
	$('#deleteDialogButton').click(function(){
		var data = $('input[name=inboxCheck]:checked').map(function() {
		      return $(this).val();
		    }).get();
    var postData = {};
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    //TODO pake serializeArray
    postData['list'] = data;
    postData['_csrf'] = csrfToken;
    var $this = $(this);
    // $this.addClass('disabled');
    var isInbox = getBoxType();
    $.ajax({
        type: 'POST',
        url : $('#deleteInboxURL').val()+'/'+isInbox,
        data: postData,
        dataType:'JSON',
        success: function (data) {
        	// if (datal == 'success'){
			      	refreshList();
              Materialize.toast('Deleted Successfully <i class="fa fa-check ml25"></i>',3000,'teal');
              $('#deleteDialog').closeModal()
        	$this.removeClass('disabled');
	        // }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
        	console.log(data);
        	$this.removeClass('disabled');
        	Materialize.toast('Deleted Failed <i class="fa fa-check ml25"></i>', 3000,'teal');
        }
    });
	});

	/** Delete Multiple message (with checkbox), munculin dialog dulu
  */
	$('#deleteInboxSelected').click(function(e){
		var data = $('input[name=inboxCheck]:checked').map(function() {
		      return $(this).val();
		    }).get();
	    if (data.length > 0) $('#deleteDialog').openModal();
	});


	/** Delete single message
  */
	$('#readDeleteButton').click(function(e){
		// Materialize.toast('TesToast: delete clicked', 3000);
	    e.preventDefault();
	    var postData = {};
	    var csrfToken = $('meta[name="csrf-token"]').attr("content");
	    var data = {};
	    data[0] = $('#readid').val();
	    // console.log(data);

	    postData['list'] = data;
	    postData['_csrf'] = csrfToken;
	    var $this = $(this);
	    // $this.addClass('disabled');
      var isInbox = getBoxType();
	    $.ajax({
	        type: 'POST',
	        url : $('#deleteInboxURL').val()+'/'+isInbox,
	        data: postData,
	        dataType:'JSON',
	        success: function (data) {
              console.log(data);
	          	// if (data == 'success'){
		            Materialize.toast('Deleted Successfully <i class="fa fa-check ml25"></i>', 3000,'teal')//, function(){
				      	// location.reload();
				      	$('#messageModal').closeModal();
				      	refreshList();
				    // });
	        	$this.removeClass('disabled');
		        // }
	        },
	        error: function (XMLHttpRequest, textStatus, errorThrown) {
	        	console.log(data);
	        	$this.removeClass('disabled');
	        	Materialize.toast('Deleted Failed <i class="fa fa-check ml25"></i>', 3000,'teal');
	        }
	    });
	});

	/** Auto Complete ( magic suggest ) untuk Message Recipient List
  */
	var autocomplete = $('#inbox-recipient').magicSuggest({
      data: $('#getListRecipientURL').val(),
      displayField: 'name',
      valueField: 'id',
      method: 'get',
      hideTrigger: true,
      placeholder: 'Choose the recipient',
      allowFreeEntries: false,
      maxSelection:null,
      renderer: function(data){
            return '<div style="padding: 5px; overflow:hidden;">' +
                      '<div style="float: left;"><img width = "40" src="' +data.avatar + '" /></div>' +
                      '<div style="float: left; margin-left: 5px">' +
                          '<div style="font-weight: bold; color: #333; font-size: 14px; line-height: 11px">'+data.name + '</div>' +
                          '<div style="color: #999; font-size: 12px">' + data.job + '</div>' +
                          '<div style="display:none">' + data.id + '</div>' +
                      '</div>' +
                    '</div><div style="clear:both;"></div>'; // make sure we have closed our dom stuff
          }
  });

  /** bersih2 form message untuk New Message
  */
	$('#buttonNewMessage').click(function(){
		autocomplete.clear();
		$('#inbox-subject, #inbox-message').val('');
	})


    /** tombol di modal NEW MESSAGE, klik untuk mengirim message
    */
    $('body').on('click','#sendMessage',function(){
      var url = $('#urlSubmit').val();
      var modal = $(this).closest('.modal');
    	var data = modal.find('form').serializeArray();
    	var $this = $(this);
    	$this.addClass('disabled');
    	$.ajax({
	        type: 'post',
	        url : url,
	        data: data,
	        dataType:'JSON',
	        success: function (response) {
	          	if (response.status == 'success'){
  		            Materialize.toast('Message Sent <i class="fa fa-check ml25"></i>', 2000,'teal', function(){
      				      	modal.closeModal();
      				      	$this.removeClass('disabled');
      				      	refreshList();
  				        });
		          // } else if (response.status == 'fail'){
            //       Materialize.toast('Choose at least 1 recipient! <i class="fa fa-check ml25"></i>', 2000,'teal');
              } else{
                  console.log(response);
                  $this.removeClass('disabled')
                  $.each(response,function(x,y){
                      $("#"+x).addClass('invalid');

                      $.each(y,function(a,b){
                        Materialize.toast(b+' <i class="fa fa-times ml25"></i>', 3000,'red accent-4');
                      });

                  })
              }
	        },
	        error: function (XMLHttpRequest, textStatus, errorThrown) {
	        	console.log('error: '+textStatus);
	        	$this.removeClass('disabled');
	        }
	    });
    });

  /**
   *  Trigger searching message
   */
  $('#searchMessage').keyup(function () {
       // var key = e.which;
       // if(key == 13)  // the enter key code
       //  {
          var searchKey = $(this).val(); //get value from searchTextbox
          refreshList(searchKey);
          // return false;
        // }
  });

  /**
   *  load message sesuai dengan boxtype (Inbox or Sent Item)
   */
  $('.messagebox').click(function(){  //load box data with AJAX when clicked
      var boxType = $(this).attr('id');
      var name= $('#dropdownMessageBoxList').find('a#dd'+boxType).html();
      $('#dropdownMessageBox').find('span').html(name);
      var url = $('.h-tabRow').find('#tabInboxURL').val();
      $.ajax({
          type: "GET",
          url: url+'/'+boxType,
          success: function (data) {
              showMessage(data);
          },error: function (data) {
              console.log('Error:', data);
          }
      });
  });

  $('#selectMessage').change(function(){
    var val = $(this).val();
    $("#"+val+".messagebox").trigger("click");
  })

  // Approve Time Off
  $('body').on('click','.inboxApprovalButton', function(e){
    Materialize.toast('Please wait...', 7000);
    var $this = $(".inboxApprovalButton");
    $this.addClass('disabled');
    e.preventDefault();
    var postData = {};
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    var approve = $(this).attr("value");
    if      (approve == 'approve') var url= $('#approveRequestURL').val();
    else if (approve == 'reject' ) var url= $('#rejectRequestURL').val();
    var reason = $('.inboxReason').val();
    postData['_csrf'] = csrfToken;
    postData['id'] = $('#readid').val();
    postData['reason'] = reason;
    // postData['approve'] = approve;
    // postData['inboxID'] = $('#inboxID').val();
    // postData['inboxMessage'] = $('#inboxMessage').val();
    $.ajax({
        type: 'post',
        url : url,
        data: postData,
        dataType:'JSON',
        success: function (data) {
          if(data.status == 'approved'){
            Materialize.toast('You have Approved this Time off Request <i class="fa fa-check ml25"></i>', 2000,'teal');
            $('#messageModal').closeModal();
            refreshList();
          } else if(data.status == 'rejected'){
            Materialize.toast('You have Rejected this Time off Request <i class="fa fa-check ml25"></i>', 2000,'teal');
            $('#messageModal').closeModal();
            refreshList();
          } else if(data.status == 'failed'){
              $this.removeClass('disabled');
              Materialize.toast('This employee doesn\'t have enough balance <i class="fa fa-times ml25"></i>', 3000,'red accent-4');
          } else{
              $this.removeClass('disabled');
              Materialize.toast('Opps, please refresh this page <i class="fa fa-times ml25"></i>', 3000,'red accent-4');
              location.reload();
          }
        }, error: function (data) {
           console.log(data);
           $this.removeClass('disabled');
        }
    });
    counter = 1;
  });


    /** display modal for reading message
     */
    function showMessageDetail ( data, showReplyButton ) {
        //TODO: avatar ,messages.attachment
        $('#readid').val(data.id);
        if(data.sender){
            $('#readName').html(data.sender.name);
            $('#readSenderID').val(data.sender.id);
            $('#inboxImage').attr('src',data.sender.avatar);
        } else if (data.receiver) {
            $('#readName').html(data.receiver.name);
            $('#inboxImage').attr('src',data.receiver.avatar);
        } else {
          // console.log('sender and receiver not found!');
          // console.log(data);
        }
        $('#readSubject').html(data.subject);
        $('#readTime').html(formatDate(data.created_at,'DD Month YYYY HH:MM indo'));
        var msg = '<pre class="overflowHidden">'+data.message+'</pre>';

        //message content\
        // if(data.fk_ref>0){
        // if(data.box_type>1){
        if(data.fk_ref && data.fk_ref!=0){
          ////TODO TO-DO!!
          // var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
          // var firstDate = new Date(2008,01,12);
          // var secondDate = new Date(2008,01,22);
          // alert(data.fk_ref.end_date);
          // var duration = Math.abs((data.fk_ref.end_date.getTime() - data.fk_ref.start_date.getTime())/(oneDay));
          // var duration = data.fk_ref.end_date - data.fk_ref.start_date;
          // var duration = 'date diff';

          msg = '<div class="col l12 center-align">';

          if(data.box_type==2){
              var display = 'Time Off';
              var code = data.fk_ref.policy.policy_code;
              msg+=     '<p>'+data.sender.name+' would like to request '+display+' '+code;
              msg+=     ' at this date:</p><p>';
              msg+=       '<span class="lato-bold f18 mr5">'+data.fk_ref.start_date+'</span> <span class="grey-text bold mr5">until</span>';
              msg+=       '<span class="lato-bold f18">'+data.fk_ref.end_date+'</span>';
              msg+=     '</p>';
              msg+=       '<p class="red-text bold">Description</p>';
              msg+=     '<p class="italic">'+data.fk_ref.reason+'</p>';
          } else if (data.box_type==3) {
              var display = 'Reimbursement';
              var code = data.fk_ref.policy.name;
              msg+=     '<p>'+data.sender.name+' would like to request '+display+' '+code;
              msg+= '<br><br><div><a href="'+data.fk_ref.attachment+'">Download attachment here</a></div>';//target="_blank"
              // msg+= '<div><img src="'+data.fk_ref.attachment+'" id="image-attachment" height="200px" class="center-align mlAuto mrAuto"></div>';
          }
          if(!data.approvement);
          else if(data.approvement.approved_flag == 0){ //if null (pending)
              ////template request approval
              msg+=     '<p class="red-text bold mt40">'+display+' Policy : <span class="grey-text bold italic">'+data.fk_ref.policy.name+'</span></p>';
              // msg+=     '<p class="red-text bold mb40">Time Off Requested : <span class="grey-text bold italic">'+duration+'</span></p>';
              msg+=     '<p>';
              msg+=       '<a href="#!" class="btn btnB01 mr5 inboxApprovalButton" value="approve">Accept</a>';
              msg+=      ' <a href="#!" class="btn btnB01 inboxApprovalButton" value="reject">Reject</a>';
              msg+=     '</p>';
              msg+=     '<div class="col l12 center-align mt20">';
              msg+=      ' <textarea class="form-control center-align h150 inboxReason" name="reason" row="10" placeholder="Reason:"></textarea>';
              msg+=     '</div>';
              msg+=   '</div>';
          } else {
              //template request approved
              msg+=     '<div class="col l12 mt20">';
              msg+=         '<p class="lato-light grey-text f30 bold mb15">';
              msg+=             'You have <span class="black-text">';
              if (data.approvement.approved_flag == 1) msg+='approved';
              else if (data.approvement.approved_flag == 2)msg+='rejected'; //if not 1(approved) then 2(rejected)
              msg+=             '</span> this request';
              msg+=         '</p>';
              msg+=         '<div class="col l12 center-align grey lighten-2 pad-20 lato-italic">';
              msg+=             '<p class="red-text bold">';
              if(data.approvement.reason) msg+=data.approvement.reason;
                else msg+='reason';
              msg+=             '</p>';
              msg+=             '<p class="lineHeight14"></p>';
              msg+=         '</div>';
              msg+=     '</div>';
              msg+= '</div>';
          }
        }
        $('#messageContent').html(msg);

        //reply button
        if(data.fk_ref && data.fk_ref!=0){
        // if(data.fk_ref>0){
            $('#readReplyButton').hide();
            if( data.approvement.approved_flag == 0) $('#readDeleteButton').hide();
            else $('#readDeleteButton').show();
        }else{
            $('#readDeleteButton').show();
            if( showReplyButton == true ) $('#readReplyButton').show();
            else $('#readReplyButton').hide();
        }
        $('#messageModal').openModal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            in_duration: 300, // Transition in duration
            out_duration: 200, // Transition out duration
            complete: function() { $('#messageModal').find('#replyPopup').hide(); refreshList();} //TODO gausa refresh, ckup ilangin read
        });
    }

    // get message detail for reading
    function getMessageDetail(messageID,checkValidation){
        checkValidation = checkValidation || false;
        if (getBoxType()==0) var isInbox = false;
        else                 var isInbox = true;
        var url= $('#readMessageURL').val()+'/'+messageID+'/'+isInbox +'/'+checkValidation;
        $.ajax({
            type: "GET",
            url: url,
            success: function(data){
              if(data == 'invalid') $("#1.messagebox").trigger("click");
              else showMessageDetail(data,isInbox);
            },
            error: function(data){console.log('Error:', data);}
        });
    }

    //** trigger read message
    $('body').on('click','.collection-item.avatar',function(){
        //ambil id, redirect ke route
        var messageID = $(this).attr('id');
        getMessageDetail(messageID);
    });

    //  langsung tampilin inbox begitu masuk message
    if ($('#triggerOpen').val() == 'none') $("#1.messagebox").trigger("click");

    else {
        // trigger read message from email
        refreshList();
        //  mencegah user membuka pesan milik user lain dgn tembak msgID di url
        getMessageDetail($('#triggerOpen').val(),true);
        $('#triggerOpen').val('none');
    }
});
