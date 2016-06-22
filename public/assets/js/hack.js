$(document).ready(function(){
	// ======== Select Plugin Material Hacking ==============================================
	$('select').on('change', function () {
        // re-initialize (update)
        $(this).material_select();
    });

	$.fn.material_select = function (callback) {
		var $body = $('body');
	    $(this).each(function(){
	      var $select = $(this);

	      if ($select.hasClass('browser-default')) {
	        return; // Continue to next (return false breaks out of entire loop)
	      }

	      var multiple = $select.attr('multiple') ? true : false,
	          lastID = $select.data('select-id'); // Tear down structure if Select needs to be rebuilt

	      if (lastID) {
	        $select.parent().find('span.caret').remove();
	        $select.parent().find('input').remove();

	        $select.unwrap();
	        $('ul#select-options-'+lastID).remove();
	      }

	      // If destroying the select, remove the selelct-id and reset it to it's uninitialized state.
	      if(callback === 'destroy') {
	        $select.data('select-id', null).removeClass('initialized');
	        return;
	      }

	      var uniqueID = Materialize.guid();
	      $select.data('select-id', uniqueID);
	      var wrapper = $('<div class="select-wrapper"></div>');
	      wrapper.addClass($select.attr('class'));
	      var options = $('<ul id="select-options-' + uniqueID +'" class="dropdown-content select-dropdown ' + (multiple ? 'multiple-select-dropdown' : '') + '"></ul>');
	      var selectOptions = $select.children('option');
	      var selectOptGroups = $select.children('optgroup');

	      var valuesSelected = [],
	          optionsHover = false;

	      if ($select.find('option:selected').length > 0) {
	        label = $select.find('option:selected');
	      } else {
	        label = selectOptions.first();
	      }

	      /* Create dropdown structure. */
	      if (selectOptGroups.length) {
	        // Check for optgroup
	        selectOptGroups.each(function() {
	          selectOptions = $(this).children('option');
	          options.append($('<li class="optgroup"><span>' + $(this).attr('label') + '</span></li>'));

	          selectOptions.each(function() {
	            var disabledClass = ($(this).is(':disabled')) ? 'disabled ' : '';

	            // Add icons
	            if ($select.hasClass('icons')) {
	              var icon_url = $(this).data('icon');
	              var classes = $(this).attr('class');
	              if (!!icon_url) {
	                options.append($('<li class="' + disabledClass + '"><img src="' + icon_url + '" class="' + classes + '"><span>' + $(this).html() + '</span></li>'));
	                return true;
	              }
	            }
	            options.append($('<li class="' + disabledClass + '"><span>' + $(this).html() + '</span></li>'));
	          });
	        });
	      } else {
	        selectOptions.each(function () {
	          // Add disabled attr if disabled
	          var disabledClass = ($(this).is(':disabled')) ? 'disabled ' : '';
	          if (multiple) {
	            options.append($('<li class="' + disabledClass + '"><span><input type="checkbox" class="filled-in"' + disabledClass + '/><label></label>' + $(this).html() + '</span></li>'));
	          } else {
	            // Add icons
	            if ($select.hasClass('icons')) {
	              var icon_url = $(this).data('icon');
	              var classes = $(this).attr('class');
	              if (!!icon_url) {
	                options.append($('<li class="' + disabledClass + '"><img src="' + icon_url + '" class="' + classes + '"><span>' + $(this).html() + '</span></li>'));
	                return true;
	              }
	            }
	            options.append($('<li class="' + disabledClass + '"><span>' + $(this).html() + '</span></li>'));
	          }
	        });
	      }


	      options.find('li:not(.optgroup)').each(function (i) {
	        var $curr_select = $select;
	        $(this).click(function (e) {
	          // Check if option element is disabled
	          if (!$(this).hasClass('disabled') && !$(this).hasClass('optgroup')) {
	            if (multiple) {
	              $('input[type="checkbox"]', this).prop('checked', function(i, v) { return !v; });
	              toggleEntryFromArray(valuesSelected, $(this).index(), $curr_select);
	              $newSelect.trigger('focus');

	            } else {
	              options.find('li').removeClass('active');
	              $(this).toggleClass('active');
	              $curr_select.siblings('input.select-dropdown').val($(this).text());
	            }

	            activateOption(options, $(this));
	            $curr_select.find('option').eq(i).prop('selected', true);
	            // Trigger onchange() event
	            $curr_select.trigger('change');
	            if (typeof callback !== 'undefined') callback();
	          }

	          e.stopPropagation();
	        });
	      });

	      // Wrap Elements
	      $select.wrap(wrapper);
	      // Add Select Display Element
	      var dropdownIcon = $('<span class="caret"><i class="fa fa-plus"></i></span>');
	      if ($select.is(':disabled'))
	        dropdownIcon.addClass('disabled');

	      // escape double quotes
	      var sanitizedLabelHtml = label.html() && label.html().replace(/"/g, '&quot;');

	      var $newSelect = $('<input type="text" class="select-dropdown" readonly="true" ' + (($select.is(':disabled')) ? 'disabled' : '') + ' data-activates="select-options-' + uniqueID +'" value="'+ sanitizedLabelHtml +'"/>');
	      $select.before($newSelect);
	      $newSelect.before(dropdownIcon);

	      $body.append(options);
	      // Check if section element is disabled
	      if (!$select.is(':disabled')) {
	        $newSelect.dropdown({'hover': false, 'closeOnClick': false});
	      }

	      // Copy tabindex
	      if ($select.attr('tabindex')) {
	        $($newSelect[0]).attr('tabindex', $select.attr('tabindex'));
	      }

	      $select.addClass('initialized');

	      $newSelect.on({
	        'focus': function (){
	          if ($('ul.select-dropdown').not(options[0]).is(':visible')) {
	            $('input.select-dropdown').trigger('close');
	          }
	          if (!options.is(':visible')) {
	            $(this).trigger('open', ['focus']);
	            var label = $(this).val();
	            var selectedOption = options.find('li').filter(function() {
	              return $(this).text().toLowerCase() === label.toLowerCase();
	            })[0];
	            activateOption(options, selectedOption);
	          }
	        },
	        'click': function (e){
	          e.stopPropagation();
	        }
	      });

	      $newSelect.on('blur', function() {
	        if (!multiple) {
	          $(this).trigger('close');
	        }
	        options.find('li.selected').removeClass('selected');
	      });

	      options.hover(function() {
	        optionsHover = true;
	      }, function () {
	        optionsHover = false;
	      });

	      $(window).on({
	        'click': function (e){
	          multiple && (optionsHover || $newSelect.trigger('close'));
	        }
	      });

	      // Make option as selected and scroll to selected position
	      activateOption = function(collection, newOption) {
	        collection.find('li.selected').removeClass('selected');
	        $(newOption).addClass('selected');
	      };

	      // Allow user to search by typing
	      // this array is cleared after 1 second
	      var filterQuery = [],
	          onKeyDown = function(e){
	            // TAB - switch to another input
	            if(e.which == 9){
	              $newSelect.trigger('close');
	              return;
	            }

	            // ARROW DOWN WHEN SELECT IS CLOSED - open select options
	            if(e.which == 40 && !options.is(':visible')){
	              $newSelect.trigger('open');
	              return;
	            }

	            // ENTER WHEN SELECT IS CLOSED - submit form
	            if(e.which == 13 && !options.is(':visible')){
	              return;
	            }

	            e.preventDefault();

	            // CASE WHEN USER TYPE LETTERS
	            var letter = String.fromCharCode(e.which).toLowerCase(),
	                nonLetters = [9,13,27,38,40];
	            if (letter && (nonLetters.indexOf(e.which) === -1)) {
	              filterQuery.push(letter);

	              var string = filterQuery.join(''),
	                  newOption = options.find('li').filter(function() {
	                    return $(this).text().toLowerCase().indexOf(string) === 0;
	                  })[0];

	              if (newOption) {
	                activateOption(options, newOption);
	              }
	            }

	            // ENTER - select option and close when select options are opened
	            if (e.which == 13) {
	              var activeOption = options.find('li.selected:not(.disabled)')[0];
	              if(activeOption){
	                $(activeOption).trigger('click');
	                if (!multiple) {
	                  $newSelect.trigger('close');
	                }
	              }
	            }

	            // ARROW DOWN - move to next not disabled option
	            if (e.which == 40) {
	              if (options.find('li.selected').length) {
	                newOption = options.find('li.selected').next('li:not(.disabled)')[0];
	              } else {
	                newOption = options.find('li:not(.disabled)')[0];
	              }
	              activateOption(options, newOption);
	            }

	            // ESC - close options
	            if (e.which == 27) {
	              $newSelect.trigger('close');
	            }

	            // ARROW UP - move to previous not disabled option
	            if (e.which == 38) {
	              newOption = options.find('li.selected').prev('li:not(.disabled)')[0];
	              if(newOption)
	                activateOption(options, newOption);
	            }

	            // Automaticaly clean filter query so user can search again by starting letters
	            setTimeout(function(){ filterQuery = []; }, 1000);
	          };

	      $newSelect.on('keydown', onKeyDown);
	    });

	    function toggleEntryFromArray(entriesArray, entryIndex, select) {
	      var index = entriesArray.indexOf(entryIndex);

	      if (index === -1) {
	        entriesArray.push(entryIndex);
	      } else {
	        entriesArray.splice(index, 1);
	      }

	      select.siblings('ul.dropdown-content').find('li').eq(entryIndex).toggleClass('active');
	      select.find('option').eq(entryIndex).prop('selected', true);
	      setValueToInput(entriesArray, select);
	    }

	    function setValueToInput(entriesArray, select) {
	      var value = '';

	      for (var i = 0, count = entriesArray.length; i < count; i++) {
	        var text = select.find('option').eq(entriesArray[i]).text();

	        i === 0 ? value += text : value += ', ' + text;
	      }

	      if (value === '') {
	        value = select.find('option:disabled').eq(0).text();
	      }

	      select.siblings('input.select-dropdown').val(value);
	    }
	};
	// ======== END Select Plugin Material Hacking ==========================================
})

// ======== Dropdown Header Function Material Hacking ===================================
$.fn.dropdown = function (option) {
    var defaults = {
      inDuration: 300,
      outDuration: 225,
      constrain_width: true, // Constrains width of dropdown to the activator
      hover: false,
      gutter: 0, // Spacing from edge
      belowOrigin: false
    }

    this.each(function(){
	    var origin = $(this);
	    var options = $.extend({}, defaults, option);

	    // Dropdown menu
	    var activates = $("#"+ origin.attr('data-activates'));

	    function updateOptions() {
	      	if (origin.data('induration') != undefined)
	        options.inDuration = origin.data('inDuration');
	      	if (origin.data('outduration') != undefined)
	        options.outDuration = origin.data('outDuration');
	      	if (origin.data('constrainwidth') != undefined)
	        options.constrain_width = origin.data('constrainwidth');
	      	if (origin.data('hover') != undefined)
	        options.hover = origin.data('hover');
	      	if (origin.data('gutter') != undefined)
	        options.gutter = origin.data('gutter');
	      	if (origin.data('beloworigin') != undefined)
	        options.belowOrigin = origin.data('beloworigin');
	    	if (origin.data('toggle') != undefined)
	    	options.toggle = origin.data('toggle');
	    }

	    updateOptions();

	    // Attach dropdown to its activator
	    origin.after(activates);

	    /*
	      Helper function to position and resize dropdown.
	      Used in hover and click handler.
	    */
	    function placeDropdown() {
	      // Check html data attributes
	      updateOptions();

	      // Set Dropdown state
	      activates.addClass('active');

	      // Constrain width
	      if (options.constrain_width == true) {
	        activates.css('width', origin.outerWidth());
	      }
	      var offset = 0;
	      if (options.belowOrigin == true) {
	        offset = origin.height();
	      }

	      // Handle edge alignment
	      var offsetLeft = origin.offset().left;
	      var width_difference = 0;
	      var gutter_spacing = options.gutter;


	      if (offsetLeft + activates.innerWidth() > $(window).width()) {
	        width_difference = origin.innerWidth() - activates.innerWidth();
	        gutter_spacing = gutter_spacing * -1;
	      }

	      // Position dropdown
	      activates.css({
	        position: 'absolute',
	        top: origin.position().top + offset - 20,
	        //left: origin.position().left + width_difference + gutter_spacing,
	        left: origin.position().left + origin.width() - activates.width() + 6
	      });

	      // Show dropdown
	      activates.slideDown({
	        queue: false,
	        duration: options.inDuration,
	        easing: 'easeOutCubic',
	        complete: function() {
	          $(this).css({'height': '', 'overflow': 'visible'});
	        }
	      }).animate( {opacity: 1}, {queue: false, duration: options.inDuration, easing: 'easeOutSine'});;
	      /*activates.stop(true, true).css('opacity', 0)
	        .slideDown({
	        queue: false,
	        duration: options.inDuration,
	        easing: 'easeOutCubic',
	        complete: function() {
	          $(this).css('height', '');
	        }
	      }).animate( {opacity: 1}, {queue: false, duration: options.inDuration, easing: 'easeOutSine'});*/
	    }

	    function hideDropdown() {
	      activates.fadeOut(options.outDuration);
	      //activates.slideUp(options.outDuration);
	      activates.removeClass('active');
	      open = false;
	    }


	    // Hover
	    if (options.toggle) {
			var open = false;
			//origin.unbind('click.' + origin.attr('id'));
			// Hover handler to show dropdown
	    	origin.on('click', function(e){ // Mouse over
		      	if (open === false) {
		          placeDropdown();
		          open = true;
		          if (activates.hasClass('active')) {
		            $(document).bind('click.'+ activates.attr('id'), function (e) {
		              if (!activates.is(e.target) && !origin.is(e.target) && (!origin.find(e.target).length > 0) ) {
		                hideDropdown();
		                $(document).unbind('click.' + activates.attr('id'));
		              }
		            });
		          }
		        }
		        else {
		          hideDropdown();
		          open = false;
		        }
		    });

		    origin.unbind('mouseenter mouseleave');
		    activates.unbind('mouseenter mouseleave');

	    	// Click
	    }

	    // Listen to open and close event - useful for select component
	    origin.on('open', placeDropdown);
	    origin.on('close', hideDropdown);
   });
}; // End dropdown plugin
// ======== Dropdown Header Function Material Hacking ===================================