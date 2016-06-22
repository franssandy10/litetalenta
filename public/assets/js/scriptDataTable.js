$(document).ready(function(){
  //$('.dataTables_filter input').attr("placeholder", "Search...");

  
  dataTable();
  dataTableFixedCol4();
  dataTableJSON();

  if ($('custom') && $('div.custom-toolbar')) {
    $('custom').each(function(){
      var next = $(this).next().find('.custom-toolbar');
      $(this).detach().appendTo(next);
    })
  }

  

  // Make Custom Pagination for DataTable
  customTablePagination();

  $('body').on('keypress', '.goPagination input', function(e){
    $('.checkboxHeader').prop('checked',false);
    if ($(this).val() != '' ) {
      if(e.which == 13) {
       /* dataTable.page( parseInt($('.goPagination input[type="number"]').val()) - parseInt('1') ).draw( false );*/
        dataTable.fnPageChange(parseInt($(this).val()) - 1);
        $('.goPagination input[type="number"]').val('');
      }
    }
  });

  $('body').on('click','.filled-in',function(){
      var checkedStatus = this.checked;
      var thisID = $(this).attr('id');
      if(checkedStatus)
      {
        $('.dataTable.bordered.no-footer').find('#'+thisID).prop('checked', true);
      }
      else
      {
       $('.dataTable.bordered.no-footer').find('#'+thisID).prop('checked', false);
      }
  });

   
})

function dataTable(){
    dataTable = $('.dataTable').dataTable({
        destroy: true,
        "dom":'<"custom-toolbar left">fl<"clearfix"><"overflowAuto"rt>i<"custom-pagination right">p',
        "pagingType": "full_numbers",
        "autoWidth": false,
        "oLanguage": {
          "sLengthMenu": "_MENU_",
          "sSearch": "_INPUT_",
          "sSearchPlaceholder": "Search...",
          "oPaginate": {
            "sNext": ">",
            "sPrevious": "<",
            "sFirst": "<<",
            "sLast": ">>"
          }
        },
        "columnDefs": [ {
            "targets"  : 'no-sort',
            "orderable": false,
        }]
    });
}

function dataTableFixedCol4(){
    var dataTableFixedCol4 = $('#dataTableFixedCol4').dataTable({
      destroy: true,
      scrollX: true,
      "dom":'<"custom-toolbar left">flrti<"custom-pagination right">p',
      "pagingType": "full_numbers",
      "autoWidth": false,
      "oLanguage": {
        "sLengthMenu": "_MENU_",
        "sSearch": "_INPUT_",
        "sSearchPlaceholder": "Search...",
        "oPaginate": {
          "sNext": ">",
          "sPrevious": "<",
          "sFirst": "<<",
          "sLast": ">>"
        }
      },
      "columnDefs": [ {
          "targets"  : 'no-sort',
          "orderable": false,
      }]
    });

    if ($(window).width() > 500 && $('#dataTableFixedCol4').length > 0) {
        new $.fn.dataTable.FixedColumns( dataTableFixedCol4, {
            leftColumns: 4
        });
    }
}

function customTablePagination(){
  $("div.custom-pagination").html(
    '<div class="dataTables_paginate_navigate">' +
      '<div class="btn btnB01 h30 w80 goPagination">' +
          '<div class="w50p">' +
            '<input type="number" min="1" class="form-control">' +
          '</div>' +
          '<div class="gotoPage w50p h100p grey white-text mrm5 goPaginationButton">' +
            'GO' +
          '</div>' +
      '</div>' +
    '</div>'
  );
}

function dataTableJSON(){
  $('.dataTableJSON').each(function(){
        var url = $(this).closest('.dataTablePoint').find('.urlDTAjax').val();
        dataTable = $(this).dataTable({
                    destroy: true,
                    "ajax": url,
                    "processing": true,
                    "serverSide": true,
                    "serverMethod": 'POST',
                    "dom":'<"custom-toolbar left">fl<"clearfix"><"overflowAuto"rt>i<"custom-pagination right">p',
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    "oLanguage": {
                      "sLengthMenu": "_MENU_",
                      "sSearch": "_INPUT_",
                      "sSearchPlaceholder": "Search...",
                      "oPaginate": {
                        "sNext": ">",
                        "sPrevious": "<",
                        "sFirst": "<<",
                        "sLast": ">>"
                      }
                    },
                    "columnDefs": [ {
                        "targets"  : 'no-sort',
                        "orderable": false,
                    }]
        });
      })
}