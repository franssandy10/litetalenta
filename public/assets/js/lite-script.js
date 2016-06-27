// variable global
var flagAjax=false;
//numeric format
Number.prototype.format = function(n, x) {
    var re = '(\\d)(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$1,');
};

function unformat(string){
	return parseFloat(string.replace(/[^0-9-.]/g, ''))
}

//Material Select Inisialisasi
function materialSelect(){
	if ($(window).width() > 500) {
			$('select').material_select();
		} else {
			$('select').material_select('destroy');
			$('select').after('<span></span>');
		}
}

//Fungsi delete toast status, seperti saving, updating, deleting, dll/
function deleteToast(){
	$('.savingToast').length ? $('.savingToast').slideUp(300) : '';
}

// Money Masking Function
function vanillaMasker() {
	VMasker($('.money')).maskMoney({
		precision: 0,
		delimiter: ',',
		zeroCents: false
	});

	VMasker($('.npwp_format')).maskPattern('99.999.999.9-999.999');
}

function unmask(){
	VMasker($(".money")).unMask();
}

function reloadHeight(element){
	setTimeout(function(){
		var height = element.closest('li').css('height');
	    $('.bx-viewport').css("height",height);
	}, 100);
}

// Is datepicker closed
function isDonePressed(){
    return ($('#ui-datepicker-div').html().indexOf('ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all ui-state-hover') > -1);
}

//Clear Page after submitting form
function clearPage($form, data, button){
	if(data.url){
		window.location.href = data.url;
	}
	var modal = $form.parents('.modal');
	if(modal){
		modal.closeModal();
		modal.find(':input').not('.form_default,[type=hidden],[type=checkbox],[type=radio]').val('').trigger('change');
		modal.find('.form_clear').val('');
		modal.find('.form_clearDate').next().val('');
		modal.find('.html_clear').html('');
		modal.find('.form_uncheck').prop('checked', false);
		modal.find('.form_show').show();
		// modal.find('.form_clear').prop('checked', false);
		// modal.find('.form_clear input:checkbox').prop('checked', false);
	}
	button.removeClass('disabled');
}

// function for validate and if okay refresh page
function validateForm($form, $function){
	var button = $form.find('.btnB01');
	button.addClass('disabled');
	unmask();
	$.ajax({
		url:$form.attr('action'),
		method:"POST",
		dataType:'JSON',
    	async: false,
		data:$form.serializeArray(),
		success:function(data){
      		console.log(data);
			var success = $form.find('.text_success');
			if (success.length) {
				var successMessage = success.val()
			}
			if(data.status=='success'){
				if ($function) {
					$function(data);
				}
				if (success.length) {
					Materialize.toast(successMessage+'<i class="fa fa-check ml25"></i>', 3000,'teal',function(){
						clearPage($form, data, button);
					});
				}
				else {
					clearPage($form, data, button);
				}
          		flagAjax=true;
			}
			else{
				console.log('failed');
				button.removeClass('disabled')
				$.each(data,function(x,y){
						$("#"+x).addClass('invalid');

						$.each(y,function(a,b){
							Materialize.toast(b+' <i class="fa fa-times ml25"></i>', 3000,'red accent-4');
						});

				});
        		flagAjax=false;

			}
			vanillaMasker();
		},
		error:function(data){
			console.log(data);
			button.removeClass('disabled')
			$.each(data.responseJSON,function(x,y){
					$("#"+x).addClass('invalid');

					$.each(y,function(a,b){
						Materialize.toast(b+' <i class="fa fa-times ml25"></i>', 3000,'red accent-4');
					});
			})
			vanillaMasker();
      flagAjax=false;

		}
	});
}

// Detect If The view is focused to some Element
function isScrolledIntoView(elem) {
  var docViewTop = $(window).scrollTop();
  var docViewBottom = docViewTop + $(window).height();

  var elemTop = $(elem).offset().top;
  var elemBottom = elemTop + $(elem).height();

  return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom));
}

// Open Modal Loading
function loading(){
	$('#modalLoading').openModal({
		dismissible: false,
		in_duration: 2,
	})
}

// Close Modal Loading
function loadingClose(){
	$('#modalLoading').closeModal()
}


// Generate Table from NODE JS
function nodeTable(data){

	content="";
	content += '<tr>';
	countColumn = 0;
	var employee_id=data.employee_id;
	delete data['employee_id'];
	$.each(data, function(k, v) {
		countColumn++;
		tdClass = '';
		if (typeof v == 'number') {
			tdClass = 'right-align';
			v = v.format();
		}
		else {
			//v = v.replace(/@~/g, '<br>')
		};
		standardRow = '<td class="' + tdClass + '">' + v + '</td>';
		if (countRow == 0 && countColumn == 1) {
		  	content += '<th class="left-align">' + v + '</th>';
		}
		else if (countRow == 0 && countColumn != 1) {
			content += '<th class="right-align">' + v + '</th>';
		}
		else if (countRow == 1) {
		  var copyThead = $(".uiGridContent thead").html();
		  copyThead = '<table><thead>' + copyThead + '</thead></table>';
		  /*$(".uiGridHeader").html(copyThead);
		  $(".uiGridContent table thead").hide();*/
		  content += standardRow;
		  //content += '<td class="right-align"><p data-tooltip="' + k + '" class="tooltip-left displayInlineBlock maxWidth100p"><span class="truncate">' + v + '</span></p></td>';
		}
		else if (countRow != 0) {
		  	content += standardRow;
		  	loadingClose();
		}

	})
	if (countRow==0) {
		content+='<th width="150"></th>'
	}
	else {
		content+='<td  class="right-align"><a data-id="'+employee_id+'" class="red1-text lato-black text-uppercase f13 btnEditPayroll"><i class="fa fa-edit mr10"></i>Edit</a></td>'
	}
	//console.log('</tr>' + countRow);
	content += '</tr>';
	if (countRow == 0) {
		$('.table thead').append(content);
		$(".table").tablesorter();
	}
	else {
		$('.table tbody').append(content);
		$(".table").trigger("update");
		var sorting = [[0,0]];
		$(".table").trigger("sorton",[sorting]);
	}
	countRow++;
}

/* =========================================================================================================================
												DOCUMENT READY FUNCTION 
=========================================================================================================================== */

$(document).ready(function(){
	materialSelect();
	vanillaMasker();

	$('select').on('change', function(){
		if ($(window).width() < 500) {
			materialSelect();
		}
	})

	$('form').on('submit', function(e){
		e.preventDefault();
	})

	if ($('#tabs3').length){$('#tabs3').tabs()};
  	// submit button when using ID or submit can refresh
  	console.info("%cWe're hiring !" + "%c \nYou know you're developer and what we're looking for if you can find this message. \nPlease go check http://career.talenta.co","color: #9A0101; font-size: 32px; line-height: 2; font-family:Arial, Helvetica, sans-serif","color: #333; font-size: 20px; line-height: 2; font-style: normal !important; font-family:Arial, Helvetica, sans-serif");
	$('body').on('click',".submitButton",function(){
	    // $(this).parents('form').submit();
	    $form=$(this).parents('form');
			// console.log($form.attr('action'))

	    validateForm($form);
	});

	function stopPropagation(event) {
	    if (event.stopPropagation !== undefined) {
	      event.stopPropagation();
	    } else {
	      event.cancelBubble = true;
	    }
	}
	// validation when enter

	$("form").on('keydown','.validate.enter',function(event) {
		if(event.keyCode==13){
			$form=$(this).parents('form');
			validateForm($form);
			return false;
		}
	})
	// validation when enter is disabled
	$(".validate.enter_disabled").keydown(function(event) {
		if(event.keyCode==13){
			return false;
		}
	})

	//$(".button-collapse").sideNav();
	$('#side-menu').sidr({
		onOpen : function() {
			$(window).touchwipe({
			    wipeLeft: function() {
			      // Close
			      $.sidr('close', 'sidr');
			    },
			    preventDefaultEvents: false
			});
			$(window).click(function(){
				$.sidr('close', 'sidr');
			});
		}
	});


	($(window).width() <= 500) ? $('.indicator').css('bottom', 0) : $('.indicator').css('bottom', 'initial')
	$('.modal-trigger').leanModal();
	$('.dropdown-button').dropdown({
	      inDuration: 300,
	      outDuration: 225,
	      constrain_width: false, // Does not change width of dropdown to that of the activator
	      hover: true, // Activate on hover
	      gutter: 0, // Spacing from edge
	      belowOrigin: false, // Displays dropdown below the button
	      alignment: 'left', // Displays dropdown with edge aligned to the left of button
	     // / clickToggle: true
	    }
	 );

	$(window).touchwipe({
	    wipeRight: function() {
	      // Open
	      $.sidr('open', 'sidr');
	    },
	    min_move_x: 150,
	    preventDefaultEvents: false
	});


	$('.tabs.my-info.no-indicator').animate({
		scrollLeft: 500
	}, 300);

	setTimeout(function(){
		$('.tabs.my-info.no-indicator').animate({
			scrollLeft: 0
		}, 300);
	}, 700)

	// Onscroll Become Agent
	if ($('.navbar-landing').length) {
		$(window).on('scroll', navScroll);
	}

	// Auto complete Getting Started 3
	function autocomplete1() {
		$this = $('.autocompleteCustom1');
		var value = $this.val();
		var arrayHelper = [];

		var allValue = $(".autocompleteVal").map(function() {
		  return this.value;
		}).get();

		$.each(allValue, function(index, content){
			arrayHelper.push(content.replace('@|@', ''));
		})
		var checkExist = jQuery.inArray(value , arrayHelper);

		console.log(checkExist);

		if (value != "" && checkExist == -1) {
			var form = $this.closest('form');
			var parent = form.find('select#parent');
			if (parent.val() != '-- Select Parent --') {
				var withParent = '@|@'+parent.val();
			}
			else {
				var withParent = "";
			}
			var val = 	$('<div class="col l4 s12 mr5 mt5 blue-grey lighten-5 valign-wrapper pad-10 autocompleteCustom1Val" style="display:none">' +
			                '<p class="truncate grey1-text bold displayInline left left-align w95p mt0 mb0 f12">' + value + '</p>' +
			                '<i class="fa fa-times grey-text valign right-align remove1 cursorPointer"></i>' +
			            '</div>');
			$this.closest('.input-field').before(
				'<input type="hidden" name="inputcomplete[]" class="autocompleteVal" data-value="' + value + '" value="' + value + withParent + '">'
			);

			$this.closest('.input-field').next().after(val);
			parent.append('<option value="' + value +'">' + value + '</option>').material_select();
			val.fadeIn(500);

			if (!parent.closest('.input-field').is(':visible')) {
				parent.closest('.input-field').show(300);
			}
			$this.val('');
		}
		else if (checkExist != -1) {
			Materialize.toast('Already Exist <i class="fa fa-times ml25"></i>', 3000,'red accent-4');
		}
	}

	$('.autocompleteCustom1').keypress(function(event){
		if (event.which == 13) {
			event.preventDefault();
		}
	})

	$('.autocompleteCustom1').keyup(function(event) {
		if (event.which == 13) {
			event.preventDefault();
			autocomplete1();
		}
	});

	$('#addAutoComplete1').click(function(){
		autocomplete1()
	})

	$('body').on('click', '.remove1', function(){
		var thisParents = $(this).closest('.autocompleteCustom1Val');
		var thisVal 	= thisParents.find('p').text();
		thisParents.hide(300, function(){ thisParents.remove()});
		thisParents.parent().find('.autocompleteVal[data-value="' + thisVal +'"]').remove();
		thisParents.parent().find('select#parent option:contains(' + thisVal + ')').remove();
		thisParents.parent().find('select#parent').material_select();
		console.log(thisVal);
	})
	// END Auto complete Getting Started 3


	$('.calendar').datepicker({
		/*changeMonth: true,
      	changeYear: true,*/
      	dayNamesMin:[ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
      	prevText: '<i class="fa fa-arrow-left red1-text"></i>',
      	nextText: '<i class="fa fa-arrow-right red1-text"></i>',
      	onSelect: function(dateText, inst)
	    {
	        var dateObject = $(this).datepicker('getDate');
	        console.log(dateObject + ' ' + dateText);
	    }
	})

	// Listen for orientation changes
	window.addEventListener("orientationchange", function() {
		console.log('rotation changed into: ' + window.orientation);
	}, false);

	// Listen for resize changes
	window.addEventListener("resize", function() {
		// Get screen size (inner/outerWidth, inner/outerHeight)
		console.log('window size changed into: ' + $(window).width() + ' x ' + $(window).height() );
		/*materialSelect();*/
	}, false);


	if ($('.datepicker').length > 0) {
	  	$( ".datepicker" ).datepicker({
		  	dateFormat: "dd MM, yy",
    		altFormat : 'yy-mm-dd',
    		constrainInput: false,
		  	changeMonth: true,
		  	changeYear: true,
		  	showAnim: 'slideDown',
		  	dayNamesMin:[ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
	      	prevText: '<i class="fa fa-arrow-left white-text"></i>',
	      	nextText: '<i class="fa fa-arrow-right white-text"></i>',
		}).keyup(function(e) {
		    if(e.keyCode == 8 || e.keyCode == 46) {
		        $.datepicker._clearDate(this);
		    }
		});
	}
	if ($('.datepicker-birth').length > 0) {
	  	$( ".datepicker-birth" ).datepicker({
		  	dateFormat: "dd MM, yy",
    		altFormat : 'yy-mm-dd',
    		constrainInput: false,
		  	changeMonth: true,
		  	changeYear: true,
		  	showAnim: 'slideDown',
		  	yearRange: "-100:+0",
		  	maxDate: "today",
		  	dayNamesMin:[ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
	      	prevText: '<i class="fa fa-arrow-left white-text"></i>',
	      	nextText: '<i class="fa fa-arrow-right white-text"></i>',
		}).keyup(function(e) {
		    if(e.keyCode == 8 || e.keyCode == 46) {
		        $.datepicker._clearDate(this);
		    }
		});
	}
	if ($('.monthpicker').length) {
		$('.monthpicker').datepicker(
        {
            dateFormat: "MM yy",
    		altFormat : 'yy-mm',
    		constrainInput: false,
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onClose: function(dateText, inst) {
            	inst.dpDiv.removeClass('month_year_datepicker');
                if (isDonePressed()){
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                   	$(this).datepicker('setDate', new Date(year, month, 1)).trigger('change');

                    $('.date-picker').focusout()//Added to remove focus from datepicker input box on selecting date
                }
            },
            beforeShow : function(input, inst) {

                inst.dpDiv.addClass('month_year_datepicker');

                if ((datestr = $(this).val()).length > 0) {
                    year = datestr.substring(datestr.length-4, datestr.length);
                    month = datestr.substring(0, 2);
                    $(this).datepicker('option', 'defaultDate', new Date(year, month-1, 1));
                    $(this).datepicker('setDate', new Date(year, month-1, 1));
                    $(".ui-datepicker-calendar").hide();
                }
                $('.ui-datepicker-buttonpane button').addClass('btnB04 mr5');
            },
            onChangeMonthYear: function (yy, mm, inst) {
		    },
            dayNamesMin:[ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
	      	prevText: '<i class="fa fa-arrow-left white-text"></i>',
	      	nextText: '<i class="fa fa-arrow-right white-text"></i>'
        }).keyup(function(e) {
		    if(e.keyCode == 8 || e.keyCode == 46) {
		        $.datepicker._clearDate(this);
		    }
		})
	}
	$('.datepicker, .monthpicker, .datepicker-birth').each(function(){
		$(this).after('<input type="hidden" class="altField" id="_' + this.id + '" name="' + this.name + '">');
		this.name = this.name + '_submit';
		$(this).datepicker("option", "altField", "#_" + this.id);
		var date = $(this).attr('value');
		if (date) {
			$(this).datepicker('setDate', new Date(date));
		}
	})

	$('.col.l10.h-tabRow').css('min-height', $('.col.l10.h-tabRow').prev('.col.l2').height() + 'px'); //Tab height

	// Buat Check All di Table
	$('.check-all').click(function(){
      var checkedStatus = this.checked;
      if($('.dataTable').length > 0)
      {
          $('.dataTable').find('tr td input[type="checkbox"].filled-in').each(function () {
              $(this).prop('checked', checkedStatus);
          });
      }
      else
      {
          $(this).parents('table').find('tr td input[type="checkbox"].filled-in').each(function () {
            $(this).prop('checked', checkedStatus);
          });
      }
    });

	// ======== Create Dropdown when province_id_fk is choose for city=============
	$("#province_id_fk").change(function(){
		$selector=$(this);
		var url=$("#url_get_city").val()+"/"+$("option:selected", this).text();
		// console.log(url);

		$.get(url, function( data ) {

			$citySelector=$selector.parents(".input-field").next();
			// find select materialize
			$selectWrapper=$citySelector.find('.select-wrapper');
			var valueCity;
			if($selectWrapper.length==1){
				valueCity=$selectWrapper.find('select').val();
			}
			else{
				valueCity=$citySelector.find('input').val();
			}
			$selectWrapper.remove();
			value=$citySelector.find('input').val();
			$citySelector.find('input').remove();
			if(data.status=='nodata'){
				$citySelector.prepend('<input id="city" class="validate enter" name="city" type="text">');
					$citySelector.find('input').val(value);
			}
			else{
				var option="";
				$.each(data,function(key,value){
					option+="<option value='"+value+"'>"+value+"</option>";
				});

				$citySelector.prepend('<select id="city" class="validate enter initialized" name="city">'+option+'</select>');
				$citySelector.find('select').val(valueCity);
				$citySelector.find('select').material_select();
				$citySelector.find('label').removeClass('active');
			}
		});
	});

	// ======== Create Dropdown when province_id_fk is choose for city=============

	// Check buat di cloned datatable
    $('body').on('change','.filled-in.cloned_dt',function(){
        var checkedStatus = this.checked;
        var thisID = $(this).attr('id');
        if(checkedStatus) {
            $('.dataTable.bordered.no-footer.DTFC_Cloned').find('#'+thisID).prop('checked', true);
            $(this).addClass('checked-trans');
        }
        else {
            $('.dataTable.bordered.no-footer.DTFC_Cloned').find('#'+thisID).prop('checked', false).removeClass('checked-trans');
            $(this).removeClass('checked-trans');
        }
    });


    // Run Payroll's like Table
    $('table').on('click', '.breakdown a', function(){
		$(this).closest('td').find('.detail-content').toggle('medium')
	});

	$('body').on('keyup', '#searchLive, .searchLive', function(){
		var $this = $(this);
		// Retrieve the input field text and reset the count to zero
		var filter = $this.val(), count = 0;

		var $index = ':eq(' + $('#columnselect').val() + ')';
		if ($('#columnselect').val() == 'all' || $('#columnselect').length == 0) {
		  $index = '';
		}

		var parent = $(this).closest('.row');
		// console.log(parent.next('.row').find("table tbody tr").length);
		// Loop through the table
		parent.next('.row').find("table tbody tr").each(function(){
		    // If the list item does not contain the text phrase fade it out
		    if ($(this).find('td' + $index).text().search(new RegExp(filter, "i")) < 0) {
		        $(this).closest('tr').fadeOut();

		    // Show the list item if the phrase matches and increase the count by 1
		    } else {
		        $(this).closest('tr').fadeIn();
		        count++;
		    }
		});// Loop through the table
	}) // Searchlive

	// Sorting Click
	$("body").on('click', '.uiGridHeader th', function () {
		loading();
		var index = $('.uiGridHeader th').index(this);
		var $this = $(this);
		$('.uiGridContent th')[index].click();
		$('.uiGridHeader th').removeClass('headerSortDown headerSortUp')

		setTimeout(function(){
		  var className = $($('.uiGridContent th')[index]).attr('class');
		  $this.addClass(className);
		}, 500);
		setTimeout(function(){
		  loadingClose();
		}, 2000)
	}); // Sorting Click

	$('.fileBtn').click(function(){
		$(this).next('.hide').find('input[type="file"]').click();
	});

	// Search Employee Template
	$('body').on('keyup', '.searchEmployee', function(){
		var filter = $(this).val(), count = 0;
		$(this).parent('.searchEmployeeWrapper').next('div:first').find('ul > li').each(function(){
		    // If the list item does not contain the text phrase fade it out
		    if ($(this).find('input[type="checkbox"]').next('label').text().search(new RegExp(filter, "i")) < 0) {
		        $(this).closest('li').fadeOut();
		    // Show the list item if the phrase matches and increase the count by 1
		    } else {
		        $(this).closest('li').fadeIn();
		        count++;
		    }
		});
	});

	$('.closeSearchEmployee').change(function(){
		var parent = $(this).closest('.input-field');
		var search = parent.next().find('.searchEmployee');
		var checked = $(this).is(':checked');
		if (search.length) {
			if (checked == true) {
				parent.next().slideUp(200);
			}
			else {
				parent.next().slideDown(200);
			}
		}
	})

	// Add New Box Template, Like Add New Department in Employee Add
	$('a.addNewBox').click(function(){
		var parent = $(this).next('div.addNewBox');
		parent.slideToggle(200);
		if (parent.is(':visible')) {
			parent.find('input[type="text"]').focus();
		}

	});

	$('div.addNewBox .btnB02').click(function(){
		var element = $(this).prev('input');
		var target = $(this).closest('.input-field').find('select');

		addSelect(element, target);
	})

	$('div.addNewBox input[type="text"]').keyup(function(e){
		if (e.which == 13) {
			var element = $(this);
			var target = $(this).closest('.input-field').find('select');
			addSelect(element, target);
		}
	})

	function addSelect(element, target){
		var arrayHelper = [];

		$.each(target.find('option'), function(index, content){
			arrayHelper.push($(this).text());
		})

		var checkExist = jQuery.inArray(element.val() , arrayHelper);

		if (element.val() != '' && checkExist == -1 ) {
			target.append('<option value="' + element.val() + '">' + element.val() + '</option>');
			materialSelect();
			target.val(element.val()).trigger('change');
			element.val('');
			element.parent('.addNewBox').slideUp(200);
		}
		else if (checkExist != -1 ) {
			Materialize.toast('Already Exist <i class="fa fa-times ml25"></i>', 3000,'red accent-4');
			element.addClass('invalid');
		}
		else {
			Materialize.toast('Please fill first <i class="fa fa-times ml25"></i>', 3000,'red accent-4');
			element.addClass('invalid');
		}
	}

	$('body').on('click', '#btnAddNewComponent', function(){
		$('#modalAddPayrollComponent').openModal();
	});
  $('#componentSelect').change(function(){
    console.log($( "#componentSelect option:selected").data('amount'));
    $('#componentAmount').val($( "#componentSelect option:selected").data('amount'));
    // butuh trigger change
  });
	$('#confirmAddComponent').click(function(){
    	var name = $('#componentSelect option:selected').text();
		var value = $('#componentSelect ').val();
		var amount = $('#componentAmount').val();
		var type = $('#modalAddPayrollComponent .titleModalComponent').text().toLowerCase();
		if ($('#tableComponent').length && type == 'add') {
			var row = $('#tableComponent .template:first').clone();
			if ($('#componentDiv .template').length == 1) {
				$('#componentDiv').show();
			}

			row.find('td.componentName').html(name + '<input type="hidden" name="component_ids[]" value="' + value + '" class="componentName">');
			row.find('td.componentAmount').html(amount + '<input type="hidden" name="component_amounts[]" value="' + unformat(amount) + '" class="componentAmount">');
			$('#tableComponent').append(row);
			row.show();
			alert(value)
			$('#modalAddPayrollComponent #componentSelect option[value="' + value + '"]').attr('disabled', 'disabled')
			$('#modalAddPayrollComponent form')[0].reset();
			$('#modalAddPayrollComponent select').trigger('change').material_select();
		}
		else if ( type == 'edit') {
			rowParent.find('td.componentAmount').html(amount + '<input type="hidden" name="component_amounts[]" value="' + unformat(amount) + '" class="componentAmount">');
		}
		reloadHeight($('#btnAddNewComponent'));
	});

	$('body').on('click', '.editComponent', function(){
		var parent = $(this).closest('tr');
		rowParent = $(this).closest('tr');
		var name = parent.find('input.componentName').val();
		var amount = parent.find('input.componentAmount').val();
		$('#modalAddPayrollComponent .titleModalComponent, #confirmAddComponent').text('Edit');
		$('#modalAddPayrollComponent').openModal({
			complete: function(){
				$('#modalAddPayrollComponent form')[0].reset();
				$('#modalAddPayrollComponent select').removeAttr('disabled').trigger('change');
				$('#modalAddPayrollComponent .titleModalComponent, #confirmAddComponent').text('Add');
			}
		});
		$('#modalAddPayrollComponent select#componentSelect').val(name).attr('disabled', 'disabled').trigger('change');
		$('#modalAddPayrollComponent #componentAmount').val(amount).trigger('keyup');
	});

	$('body').on('click', '.removeComponent', function(){
		rowParent = $(this).closest('tr');
		var id = rowParent.find('td.componentName input:hidden').val();
		$('#componentSelect option[value="'+ id + '"]').removeAttr('disabled')
		$('#modalDeletePayrollComponent').openModal();
		materialSelect();
	});

	$('#yesDeleteComponent').click(function(){
    id=rowParent.find('.component_id').val();
    if($("#component_id_delete").val()==""){
      $("#component_id_delete").val(id);

    }
    else{
      $("#component_id_delete").val($("#component_id_delete").val()+","+id);
    }
		rowParent.remove();
		reloadHeight($('#btnAddNewComponent'));
	});

	$('body').on('focus', ".money, .focus", function(){
		$(this).select();
	});

	$('body').on('click', '.disabledWarning', function(){
		$('.disabledWarningDiv').slideToggle(300);
		setTimeout(function(){
			$('.disabledWarningDiv').slideToggle(300);
		}, 5000)
	});

	$('.addTableRow').click(function(){
		var target = $(this).data('target');
		var table = $('#' + target);
		var clone = table.find('.template:first').clone();
		clone.show();
		table.find('tbody').append(clone);
	})

	$('table').on('click', '.deleteTableRow', function(){
		$(this).closest('tr').remove();
	});

	$('#tabs3 div.indicator').remove();

	$('#noNPWP').change(function(){
		reloadHeight($(this));
		if ($(this).is(':checked')) {
			$('#noNPWPDiv').hide();
		}
		else {
			$('#noNPWPDiv').show();
		}
	}).change();

	$('input[name="salary_config"]:radio').change(function(){
		var $this = $(this);
		if ($('#taxable[name="salary_config"]').is(':checked')) {
			$('#taxableSalaryDiv').show(200);
		}
		else {
			$('#taxableSalaryDiv').hide(200);
		}
		reloadHeight($this);
	}).change();
	/*alert($('input[name="salary_config"][type=radio]').length);*/

	// toggle show/hide end_date when user choose Half-Day in modal Request Time-Off
	$('#toggleHalfDay').change(function(){
		if($(this).is(':checked')) $('#endDateSection').hide(200);
		else $('#endDateSection').show(200);
	})


	// For Create Component
	$('#component_type_occur').change(function(){
		if ($(this).val() == 1) {
      // jika deduction ga bisa diprorarte
      //  && $('#modalCreatePayrollComponent .titleModalComponent').text().toLowerCase() != 'deduction'
			$('#prorateDiv').slideDown(200)
		}
		else {
			$('#prorateDiv').slideUp(200)
		}
	})

	$('[href="#modalCreatePayrollComponent"]').click(function(){
		$('#modalCreatePayrollComponent .titleModalComponent').text($(this).data('type'));
		$('#modalCreatePayrollComponent form')[0].reset();
		$('#modalCreatePayrollComponent #component_type_occur').val(1).change();
    	$('#component_type').val($(this).data('type'));
	});

	$('body').on('click', '.delComponent', function(e){
		e.stopPropagation();
		$('#modalDeleteComponent').openModal();
		var url = $(this).data('url')
		$('#yesDeleteComponentCreated').data('url', url)
	})

	$('body').on('click', '.componentWrapper', function(){
		$.ajax({
			url: $(this).data('view'),
			dataType: 'JSON',
			success: function(data){
				console.log(data);
				$('#employeeAttachment').hide();
				$('#modalCreatePayrollComponent .titleModalCreatePayrollComponent').text(data[0].component_name);
				$('#modalCreatePayrollComponent #component_name').val(data[0].component_name);
				$('#modalCreatePayrollComponent #component_amount').val(data[0].component_amount);
				$('#modalCreatePayrollComponent #component_type_occur').val(data[0].component_type_occur).change();
				$('#modalCreatePayrollComponent #prorate_component').prop('checked', (data[0].prorate_flag == 0) ? false : true);
				$('#modalCreatePayrollComponent [name="component_tax_type"]').val(data[0].component_tax_type).change();
				$('#modalCreatePayrollComponent #default_flag').prop('checked', (data[0].default_flag == 0) ? false : true);
				vanillaMasker()

				$('#addPayrollCompBtn').hide();
				$('#modalCreatePayrollComponent .modal-close').text('Close');
				$('#modalCreatePayrollComponent form').find('input:text:not(.select-dropdown), select, input:checkbox').attr('disabled','disabled').change().removeClass('invalid');
				materialSelect();
				$('#modalCreatePayrollComponent').openModal({
					ready: function(){
						if ($('#modalCreatePayrollComponent .modal-content').scrollTop() > 50) {
							$('#modalCreatePayrollComponent .modal-content').animate({
								scrollTop : 0
							}, 200)
						}
					},
					complete: function() { 
						$('#modalCreatePayrollComponent form').find('input:text:not(.select-dropdown), select, input:checkbox').removeAttr('disabled');
						materialSelect();
						$('#modalCreatePayrollComponent form')[0].reset();
						$('#modalCreatePayrollComponent #component_type_occur').val(1).change();
						$('.lean-overlay').remove()
						$('#employeeAttachment, #addPayrollCompBtn').show();
						$('#modalCreatePayrollComponent .modal-close').text('Cancel')
						$('#modalCreatePayrollComponent .titleModalCreatePayrollComponent').html('Add <span class="titleModalComponent">Payroll</span> Component')
					}
				});
			},
			error: function(){
				Materialize.toast('Error <i class="fa fa-times ml25"></i>', 3000,'red accent-4');
			}
		});
	});

	// custom Tab berbentuk select
	$('.tab-select').change(function(){
		var val = this.value;
		$('.tab-select-container').hide("slide", { direction: "right" }, 300);
		setTimeout(function(){
			$('.tab-select-container#' + val).show("slide", { direction: "left" }, 300);
		}, 300)
	})

	$('.tab-selector-mobile').change(function(){
		var val = $(this).val();
		$(this).closest('.input-field').next().find('ul li.tab a[href="#' + val + '"]').trigger('click');

	})

}) // Document Ready ================

if ($('.navbar-fixed').length) {
	var nav = document.querySelector('.navbar-fixed');
	var agentBar = document.querySelector('#becomeAgentDiv');
	var origOffsetY = nav.offsetTop;



	function navScroll(e) {
		if (window.scrollY >= 150) {
			$('#main-logo').attr('src', 'assets/images/talenta-logo.png');
			nav.classList.add('scrolled');
		}
		else {
			nav.classList.remove('scrolled');
			$('#main-logo').attr('src', 'assets/images/talenta-logo-white.png');
		}

		isScrolledIntoView($('footer.page-footer')) ?  agentBar.classList.remove('fixed') : agentBar.classList.add('fixed') ;
	}
}
