/* 
 * It will have all js functionality related to showings
 */
//$.jMaskGlobals.watchDataMask = true;

$(".cpointer  ").css("cursor", "pointer");
 $(function () {

  if (0 < ($('#showings_list')).length) {

    var selector = '#showings_list', postUrl = "/showings/list";
       // var totalCost = data.additional_fee + data.list_price ;


       var dtCols = [
       {"data": "id", "visible":false, "searchable": false,
       "orderable": false },
       {"title": "Posting Agent", "data": "user_name"},
       {"title": "Showing Date", "data": "post_date"},
       {"title": "Start Time", "data": "start_time"},
       {"title": "End Time", "data": "end_time"},

       {"title": "Amount", "data": "list_price", "searchable": false},

       {"title": "Showings", "data": "house_count", "searchable": false,
       "orderable": false},
       {"title": "", "data": "id",
       "render": function (data, type, row, meta) {


        var editIcon = '<a onclick="viewShowing(' + data + ')"' +
        ' title="View"><i class="fa' +
        ' fa-eye fa-2x text-green"></i></a>';
        return editIcon;
      }, "searchable": false, "orderable": false
    }
    ];

    showingsDataTable = bindDatatable(selector, postUrl, dtCols);
    new $.fn.dataTable.ColReorder(showingsDataTable);
  }

  if ($('#dv_postShowing').is(':visible')) {
        // code to show datepicker (jQuery)
        var today = new Date();
        var tomorrow = new Date();
        tomorrow.setDate(today.getDate() + 1);
        $(".date-picker").datepicker({
          minDate: tomorrow,
          showButtonPanel: true,
          changeMonth: true,
          changeYear: true,
          dateFormat: 'mm/dd/yy',
          onSelect: function(dateText, inst) {
            if ('' !== dateText) {
              var elem = $(this).attr('name');

              $('#frm_postShowingForm')
                        // Get the bootstrapValidator instance
                        .data('bootstrapValidator')
                        // Mark the field as not validated, so it'll be re-validated when the user change date
                        .updateStatus(elem, 'NOT_VALIDATED', null)
                        // Validate the field
                        .validateField(elem);
                      }
                    }
                  });

        // code to show datetimepicker (bootstrap datetimepicker)
        $('.date-time-picker').datetimepicker({
           // format: 'h:00:00',

           format: "HH:00:00 P",
           showMeridian: true,
           pickDate: false,
           startView: 1,
           minView: 1,
           maxView: 1,
           autoclose: true,
           todayBtn: false
         }).on("show", function(ev) {
          $(".glyphicon-arrow-left").css('visibility', 'hidden');
          $(".glyphicon-arrow-right").css('visibility', 'hidden');
          $(".table-condensed .next").css('visibility', 'hidden');
          $(".table-condensed .prev").css('visibility', 'hidden');

          var showingDate = $.trim($('#post_date').val());
      //alert(showingDate);
      if(0 < showingDate.length) {
        var showingDateObj = showingDate.split("/");

                //var timeStr = $.trim(showingDateObj[2] + "-" + showingDateObj[0] + "-" + showingDateObj[1]+ " "+ $(this).val());
                var timeStr = $.trim(showingDateObj[2] + "-" + showingDateObj[0] + "-" + showingDateObj[1]);
          //alert(timeStr);
          $(this).datetimepicker("update", timeStr);
        }
      });

        // on selecting date time picker, validate the field
        $(".date-time-picker").on("change.dp", function(e) {
          var elem = $(this).attr('name');

          $('#frm_postShowingForm')
                // Get the bootstrapValidator instance
                .data('bootstrapValidator')
                // Mark the field as not validated, so it'll be re-validated when the user change date
                .updateStatus(elem, 'NOT_VALIDATED', null)
                // Validate the field
                .validateField(elem);
              });

        // add the additional fee the user will pay to LMS agent
        $('#additional_fee').keyup(function() {
          var totalPayment = 0;
          var agentPayment = 0;
          var lmsPayment = 0;

          $('.showing-list-price').each(function() {
            var listPrice = $(this).val().match(/-?\d+\.?\d*/);

            if (null !== listPrice) {
              totalPayment = totalPayment + parseFloat(listPrice) + 15;
              agentPayment = agentPayment + parseFloat(listPrice);
            } else {
              totalPayment = totalPayment + 15;
            }

            lmsPayment = lmsPayment + 15;
          });

          var additionalFee = $(this).val().match(/-?\d+\.?\d*/);
          if (null !== additionalFee) {
         
              var newaddotionalAgent =  (additionalFee*80)/100;
                  var newaddotionalLms =  (additionalFee*20)/100;

                lmsPayment = lmsPayment + parseFloat(newaddotionalLms);
                agentPayment = agentPayment + parseFloat(newaddotionalAgent);
                totalPayment = totalPayment + parseFloat(additionalFee);
              }

              $('#dd_totalPayment').html('$' + totalPayment);
              $('#dd_agentPayment').html('$' + agentPayment);
              $('#dd_lmsPayment').html('$' + lmsPayment);
            });

$('.showing-list-price').keyup(function() {
  changeListPrice();
});
}

if((0 < ($('#posted_showings_list')).length) ||
  (0 < ($('#accepted_showings_list')).length)) {
  var listUsersDtCols = [
{"data": "id", "visible": false, "searchable": false,
"orderable": false},
{"title": "Posting Agent", "data": "user_name"},
{"title": "Showing Date", "data": "post_date"},
{"title": "Start Time", "data": "start_time"},
{"title": "End Time", "data": "end_time"},
{"title": "Amount", "data": "list_price", "searchable": false},
{
  "title": "Showings",
  "data": "house_count",
  "searchable": false,
  "orderable": false
},
            // {"title": "", "data": "id",
            //     "render": function (data, type, row, meta) {
            //         var editIcon = '<a href="/showings/edit/' + data + '" title="Edit"><i class="fa' +
            //             ' fa-edit fa-2x text-green"></i></a>';
            //         return editIcon;
            //     }, "searchable": false, "orderable": false
            // }
            // {"title": "", "data": "id",
            //     "render": function (data, type, row, meta) {
            //         var deleteIcon = '<a onclick="deleteShowing(' + data + ')"' +
            //             ' title="Delete"><i class="fa' +
            //             ' fa-trash fa-2x text-red"></i></a>';
            //         return deleteIcon;
            //     }, "searchable": false, "orderable": false
            // }
            ];

            if (0 < ($('#posted_showings_list')).length) {
              var listUsersPostUrl = '/showings/list-users/posted';

              listUsersDtCols[7] = {"title": "Status", "data": "id",
              "render": function (data, type, row, meta) {
                var rejected =row.rejected_id;
                if(rejected){

                  var editIcon =  '<button style="cursor:not-allowed; width: 120px;"  type="button" title="Rejected" class="btn btn-xs btn-danger">Rejected </button>';



                }
                else{

                  if(row.showing_progress == 1){

                   var editIcon =  '<button style=" width: 120px;" type="button" onclick="acceptedUserData(' + row.showing_user_id + ','+data+')"' + 'title="Approve" class="btn btn-xs btn-danger">Pending</button> ';

                 }
                 else if(row.showing_progress == 2){

                  var editIcon =  '<button style=" width: 120px;" type="button" onclick="viewAcceptedUserData(' + row.showing_user_id + ','+data+')"' + 'title="Approved" class="btn btn-xs btn-success">Approved</button>  ';


                }


                else if(row.showing_progress == 4){
                  var editIcon = '<button  style="cursor:not-allowed ;width: 120px; padding-left:5px" type="button" title="Payment undone" class="btn btn-xs btn-danger">Payment Undone</button>';


                   //  editIcon +=  '<button  style="cursor:not-allowed ;margin-top:-14px; width: 120px;" type="button" title="Payment undone" class="btn btn-xs btn-success">Payment Undone</button>';

                 }else if(row.showing_progress == 6){
                   var editIcon =  '<button  style="cursor:not-allowed ; width: 120px;" type="button" title="Payment Done" class="btn btn-xs btn-success">Payment Done</button>';

                 }
                 else{
                  var  editIcon = "";

                }

              }

              return editIcon;
            }, "searchable": "false", "orderable": false


          };

          listUsersDtCols[8] = {"title": "Actions", "data": "id",
          "render": function (data, type, row, meta) {
            var rejected =row.rejected_id;
            if(rejected){


              var  editIcon = '&nbsp<a href="/showings/edit/' + data + '" title="Edit"><i class="fa' +
              ' fa-edit fa-2x text-green"></i></a>';

            }
            else{


             var editIcon = '&nbsp<a href="/showings/edit/' + data + '" title="Edit"><i class="fa' +
             ' fa-edit fa-2x text-green"></i></a>';

           }

           return editIcon;
         }, "searchable": "false", "orderable": false


       };



       var postedShowingsDataTable = bindDatatable('#posted_showings_list', listUsersPostUrl, listUsersDtCols);
     }



     if (0 < ($('#accepted_showings_list')).length) {
      var listUsersPostUrl = '/showings/list-users/accepted';
      listUsersDtCols[7] = {"title": "Status", "data": "id",
      "render": function (data, type, row, meta) {

        var rejected =row.rejected_id;

        if(rejected){

          var editIcon =  '<button style="cursor:not-allowed ;width: 120px;"  type="button" title="Rejected" class="btn btn-xs btn-danger">Rejected </button> ';

        }
        else{

          if(row.showing_progress == 1){
            var editIcon =  '<button style="width: 120px;" type="button"  title="Pending" class="btn btn-xs btn-danger">Pending</button> ';

          }
          else if(row.showing_progress == 2){


           var editIcon =  '<button style="width: 120px;" type="button" onclick="getFeedbackForm(' + data + ')"' + 'title="Complete Showing" class="btn btn-xs btn-success">Complete</button> ';

         }
         else if(row.showing_progress == 4){

           var editIcon =  '<button style="cursor:not-allowed;width:120px;padding-left:0px;" style="margin-top:-14px;" type="button" title="Feedback Submitted " class="btn btn-xs btn-success">Feedback Submitted </button> ';
         }else{
          var editIcon =  '<button  style="cursor:not-allowed ; width:120px;"  type="button" title="Payment Done" class="btn btn-xs btn-success">Payment Done</button> ';

        }


      }


      return editIcon;
    }, "searchable": "false", "orderable": false
  };
  /* change for status*/
  listUsersDtCols[8] = {"title": "Actions", "data": "id",
  "render": function (data, type, row, meta) {

    var editIcon ="";
    var rejected =row.rejected_id;

        if(rejected){
            editIcon += '<a style="cursor:pointer" onclick="viewShowingUser(' + data + ')"' +
      ' title="View"><i class="fa' +
      ' fa-eye fa-2x text-green"></i></a>&nbsp&nbsp<i class="fa fa-ellipsis-v fa-2x " aria-hidden="true"></i>&nbsp&nbsp';
   

  
        }

    if(row.showing_progress == 2){
      editIcon += '<a style="cursor:pointer" onclick="viewShowingUser(' + data + ')"' +
      ' title="View"><i class="fa' +
      ' fa-eye fa-2x text-green"></i></a>&nbsp&nbsp<i class="fa fa-ellipsis-v fa-2x " aria-hidden="true"></i>&nbsp&nbsp';
    }
     if(row.showing_progress == 4){
      editIcon += '<a style="cursor:pointer" onclick="viewShowingUser(' + data + ')"' +
      ' title="View"><i class="fa' +
      ' fa-eye fa-2x text-green"></i></a>&nbsp&nbsp<i class="fa fa-ellipsis-v fa-2x " aria-hidden="true"></i>&nbsp&nbsp';
    }
     if(row.showing_progress == 6){
      editIcon += '<a style="cursor:pointer" onclick="viewShowingUser(' + data + ')"' +
      ' title="View"><i class="fa' +
      ' fa-eye fa-2x text-green"></i></a>&nbsp&nbsp<i class="fa fa-ellipsis-v fa-2x " aria-hidden="true"></i>&nbsp&nbsp';
    }

    editIcon +='<a style="cursor:pointer"  onclick="deleteShowing(' + data + ')"' +
    ' title="Delete"><i class="fa' +
    ' fa-trash fa-2x text-red"></i></a>';



    return editIcon;
  }, "searchable": "false", "orderable": false
};

/*End change status*/



var postedShowingsDataTable = bindDatatable('#accepted_showings_list', listUsersPostUrl, listUsersDtCols);
}

/*new block by sandeep*/
if (0 < ($('#approved_showings_list_posted')).length) {
  var listUsersPostUrl = '/showings/list-users/accepted';
  listUsersDtCols[7] = {"title": "Actions", "data": "id",
  "render": function (data, type, row, meta) {
   var rejected =row.rejected_id;

   if(rejected){

    var editIcon =  '<button style="cursor:not-allowed;margin-top:-14px;width: 120px;" style="margin-top:-14px;" type="button" title="Showing rejected" class="btn btn-xs btn-danger">Showing rejected </button>&nbsp<i class="fa fa-ellipsis-v fa-2x " aria-hidden="true"></i>  ';

  }
  else{

    if(row.showing_progress == 2){

      var  editIcon = '&nbsp<a style="cursor:pointer" onclick="viewShowingUser(' + data + ')"' +
      ' title="View"><i class="fa' +
      ' fa-eye fa-2x text-green"></i></a>';

    }
  }



  return editIcon;
}, "searchable": "false", "orderable": false
};



listUsersDtCols[8] = {"title": "", "data": "id",
"render": function (data, type, row, meta) {

  var  editIcon = "";



  return editIcon;
}, "searchable": "false", "orderable": false
};




var postedShowingsDataTable = bindDatatable('#approved_showings_list_posted', listUsersPostUrl, listUsersDtCols);
}




if (0 < ($('#accepted_showings_list_posted')).length) {
  var listUsersPostUrl = '/showings/list-users/accepted';
  listUsersDtCols[7] = {"title": "Actions", "data": "id",
  "render": function (data, type, row, meta) {
   var rejected =row.rejected_id;

   if(rejected){

    var editIcon =  '<button style="cursor:not-allowed;margin-top:-14px;width: 120px;" style="margin-top:-14px;" type="button" title="Showing rejected" class="btn btn-xs btn-danger">Showing rejected </button>&nbsp<i class="fa fa-ellipsis-v fa-2x " aria-hidden="true"></i>  ';

  }
  else{

    if(row.showing_progress == 2){

      var  editIcon = '&nbsp<a style="cursor:pointer" onclick="viewShowingUser(' + data + ')"' +
      ' title="View"><i class="fa' +
      ' fa-eye fa-2x text-green"></i></a>';

    }
  }



  return editIcon;
}, "searchable": "false", "orderable": false
};
var postedShowingsDataTable = bindDatatable('#accepted_showings_list_posted', listUsersPostUrl, listUsersDtCols);
}

/*rejected list*/


if (0 < ($('#rejected_showings_list_posted')).length) {
  var listUsersPostUrl = '/showings/list-users/rejected';

  listUsersDtCols[7] = {"title": "Actions", "data": "id",
  "render": function (data, type, row, meta) {
   var rejected =row.rejected_id;

   if(rejected){

    var  editIcon = '&nbsp<a style="cursor:pointer" onclick="viewShowingUserRejected(' + data + ')"' +
    ' title="View"><i class="fa' +
    ' fa-eye fa-2x text-green"></i></a>';
  }



  return editIcon;
}, "searchable": "false", "orderable": false
};


listUsersDtCols[8] = {"title": "", "data": "id",
"render": function (data, type, row, meta) {
 var rejected =row.rejected_id;

 if(rejected){


  var  editIcon = "";
}



return editIcon;
}, "searchable": "false", "orderable": false
};






var postedShowingsDataTable = bindDatatable('#rejected_showings_list_posted', listUsersPostUrl, listUsersDtCols);
}


/* Completed showing for posting agent*/


if (0 < ($('#completed_showings_list_posted')).length) {
  var listUsersPostUrl = '/showings/list-users/completed';
  listUsersDtCols[8] = {"title": "Actions", "data": "id",
  "render": function (data, type, row, meta) {
   var rejected =row.rejected_id;

   if(rejected){

    var  editIcon = '&nbsp<a style="cursor:pointer" onclick="viewShowingUser(' + data + ')"' +
    ' title="View"><i class="fa' +
    ' fa-eye fa-2x text-green"></i></a>';
  }
  else {

   if(row.showing_progress == 4){
     var  editIcon = '&nbsp<a style="cursor:pointer" onclick="viewShowingUser(' + data + ')"' +
     ' title="View"><i class="fa' +
     ' fa-eye fa-2x text-green"></i></a>';
   }

   else if(row.showing_progress == 6){
     var  editIcon = '&nbsp<a  style="cursor:pointer ;" onclick="viewShowingUser(' + data + ')"' +
     ' title="View"><i class="fa' +
     ' fa-eye fa-2x text-green"></i></a>';


   }

 }
 return editIcon;
}, "searchable": "false", "orderable": false
};


listUsersDtCols[7] = {"title": "Status", "data": "id",
"render": function (data, type, row, meta) {

 if(row.showing_progress == 4){ 
  var  editIcon =  '<button ; style=" padding-left:5px;cursor:not-allowed ; width: 120px;" type="button" title="Payment undone" class="btn btn-xs btn-danger">Payment Undone</button>';

}

else if(row.showing_progress == 6){

  var editIcon =  '<button  style="cursor:not-allowed ; width: 120px;" type="button" title="Payment Done" class="btn btn-xs btn-success">Payment Done</button>';
}
return editIcon;
}, "searchable": "false", "orderable": false
};

var postedShowingsDataTable = bindDatatable('#completed_showings_list_posted', listUsersPostUrl, listUsersDtCols);
}


if (0 < ($('#completed_showings_list_both')).length) {
  var listUsersPostUrl = '/showings/list-users/bothcompleted';
  listUsersDtCols[8] = {"title": "Actions", "data": "id",
  "render": function (data, type, row, meta) {
   var rejected =row.rejected_id;

   if(rejected){

    var  editIcon = '&nbsp<a style="cursor:pointer" onclick="viewShowingUser(' + data + ')"' +
    ' title="View"><i class="fa' +
    ' fa-eye fa-2x text-green"></i></a>';
  }
  else {

   if(row.showing_progress == 4){
     var  editIcon = '&nbsp<a style="cursor:pointer" onclick="viewShowingUser(' + data + ')"' +
     ' title="View"><i class="fa' +
     ' fa-eye fa-2x text-green"></i></a>';
   }

   else if(row.showing_progress == 6){
     var  editIcon = '&nbsp<a  style="cursor:pointer ;" onclick="viewShowingUser(' + data + ')"' +
     ' title="View"><i class="fa' +
     ' fa-eye fa-2x text-green"></i></a>';


   }

 }
 return editIcon;
}, "searchable": "false", "orderable": false
};


listUsersDtCols[7] = {"title": "Status", "data": "id",
"render": function (data, type, row, meta) {

 if(row.showing_progress == 4){ 
  var  editIcon =  '<button ; style=" padding-left:5px;cursor:not-allowed ; width: 120px;" type="button" title="Payment undone" class="btn btn-xs btn-danger">Payment Undone</button>';

}

else if(row.showing_progress == 6){

  var editIcon =  '<button  style="cursor:not-allowed ; width: 120px;" type="button" title="Payment Done" class="btn btn-xs btn-success">Payment Done</button>';
}
return editIcon;
}, "searchable": "false", "orderable": false
};

var postedShowingsDataTable = bindDatatable('#completed_showings_list_both', listUsersPostUrl, listUsersDtCols);
}


/* End new block*/
}

changeListPrice();

});

function changeListPrice() {
  var totalPayment = 0;
  var agentPayment = 0;
  var lmsPayment = 0;

  $('.showing-list-price').each(function() {
    var listPrice = $(this).val().match(/-?\d+\.?\d*/);

    if (null !== listPrice) {
      totalPayment = totalPayment + parseFloat(listPrice) + 15;
      agentPayment = agentPayment + parseFloat(listPrice);
    } else {
      totalPayment = totalPayment + 15;
    }

    lmsPayment = lmsPayment + 15  ;
       

  });

  var additionalFeeStr = $('#additional_fee').val();
  if(typeof(additionalFeeStr) != "undefined" && (additionalFeeStr) !== null) {
    var additionalFee = additionalFeeStr.match(/-?\d+\.?\d*/);
  }
  if (null !== additionalFee) { // If additional fee already set
    var newaddotionalAgent =  (additionalFee*80)/100; //Calculate fee for client 80%
    var newaddotionalLms =  (additionalFee*20)/100; // Calculete fee for LMS 20%
    lmsPayment = lmsPayment + parseFloat(newaddotionalLms);
    agentPayment = agentPayment + parseFloat(newaddotionalAgent);
    totalPayment = totalPayment + parseFloat(additionalFee);
  }

  $('#dd_totalPayment').html('$' + totalPayment);
  $('#dd_agentPayment').html('$' + agentPayment);
  $('#dd_lmsPayment').html('$' + lmsPayment);
}

function bindDatatable(selector, postUrl, dtCols, defSortInfo) {
  defSortInfo = ('undefined' == typeof defSortInfo) ? [] : defSortInfo;

  if ($(selector).length) {
    var bindedDatatable = $(selector).dataTable({
      "processing": false,
      "serverSide": true,
      "ajax": {
        "url": postUrl,
        "type": "POST"
      },
      "language": {
        "infoFiltered": ""
      },
      "columns": dtCols,
      "order": defSortInfo
    });
    return bindedDatatable;
  }
}

function viewShowing(id) {
  var postUrl = "/showings/view";
  $.post(postUrl,
  {
    id: id
  },
  function(data) {
    if ('' !== data) {
      $('#dv_viewShowings').html(data).modal("show");
    }
  }
  );
}

function viewShowingUser(id) {
  var postUrl = "/showings/viewUser";
  $.post(postUrl,
  {
    id: id
  },
  function(data) {
    if ('' !== data) {
      $('#dv_viewShowings').html(data).modal("show");
    }
  }
  );
}


function viewShowingUserRejected(id) {
  var postUrl = "/showings/viewShowingRejected";
  $.post(postUrl,
  {
    id: id
  },
  function(data) {
    if ('' !== data) {
      $('#dv_viewShowings').html(data).modal("show");
    }
  }
  );
}

function changeHouseCount() {
  $currentHouseCountObj = $('#hid_houseCount');

  var selectedCount = parseInt($('#house_count option:selected').val());
  var currentHouseCount = parseInt($currentHouseCountObj.val());

  if (currentHouseCount < selectedCount) {
    var totalPayment = $('#dd_totalPayment').html().match(/-?\d+\.?\d*/);
    var agentPayment = $('#dd_agentPayment').html().match(/-?\d+\.?\d*/);
    var lmsPayment = $('#dd_lmsPayment').html().match(/-?\d+\.?\d*/);

    for (var i=currentHouseCount; i < selectedCount; i++) {
      var newCount = parseInt(i) + 1;
      $clonedObj = $('#dv_houseDetails' + i).clone();

      $clonedObj.attr('id', 'dv_houseDetails' + newCount);
      $('input', $clonedObj).val('');
      $(".panel-heading a", $clonedObj).attr('href', '#dv_houseCount' + newCount);
      $(".panel-heading .sp_houseCount", $clonedObj).html(newCount);
      $("#dv_houseCount" + i, $clonedObj).attr('id', 'dv_houseCount' + newCount)
      .removeClass('in');
      $currentHouseCountObj.val(newCount);
      $('input[name="list_price[]"]', $clonedObj).val('$20');

      $clonedObj.appendTo('#dv_accordionCat');

      lmsPayment = parseFloat(lmsPayment) + 15;
      agentPayment = parseFloat(agentPayment) + 20;
      totalPayment = lmsPayment + agentPayment;
    }

    $('#dd_totalPayment').html('$' + totalPayment);
    $('#dd_agentPayment').html('$' + agentPayment);
    $('#dd_lmsPayment').html('$' + lmsPayment);

    $('.showing-list-price').keyup(function() {
      changeListPrice();
    });
  } else {
    for (var i=currentHouseCount; i > selectedCount; i--) {
      $('#dv_houseDetails' + i).remove();
      $currentHouseCountObj.val(i-1);
    }
    changeListPrice();
  }
}
//Showing accept functionality
function acceptShowing(id) {

  bootbox.dialog({
    message: "Are you sure to accept this showing?",
    buttons: {
      success: {
        label: "Yes",
        className: "btn-success",
        callback: function() {

          var btn = $('#fat-btn')
          btn.button('loading');

          $.ajax({
            "url": "/showings/accept",
            "dataType": "json",
            "type": "POST",
            "cache": false,
            "data": {id: id},
            "success": function(response) {
              if('1' == response) {
                bootbox.dialog({
                  message: "Showing accepted successfully.",
                  buttons: {
                    success: {
                      label: " OK ",
                      className: "btn-success",
                      callback: function() {
                        var btn1 = $('#fat-btn')
                        btn.button('reset');
                        window.location.reload();
                      }
                    }
                  }
                });
              } else {
                bootbox.alert( "Error detected on server, Please try again." );
              }
            },
            "error": function () {
              bootbox.alert( "Error detected on server, Please try again." );
            }
          });
}
},
danger: {
  label: "No",
  className: "btn-danger"
}
}
});
}

function getFeedbackForm(id) {
  var postUrl = "/showings/feedback-form";
  $.post(postUrl,
  {
    id: id
  },
  function(data) {
    if ('' !== data) {
      $('#dv_viewShowings').html(data).modal("show");
    }
  }
  );
}

//Showing accept functionality
function feedbackShowing(id) {

  bootbox.dialog({
    message: "Are you sure to submit feedback for this showing?",
    buttons: {
      success: {
        label: "Yes",
        className: "btn-success",
        callback: function() {
          $('#frm_feedbackForm').submit();
        }
      },
      danger: {
        label: "No",
        className: "btn-danger"
      }
    }
  });
}

//Delete showing functionality
function deleteShowing(id) {

  bootbox.dialog({
    message: "Are you sure to delete this showing?",
    buttons: {
      success: {
        label: "Yes",
        className: "btn-success",
        callback: function() {
          window.location = "/showings/delete/" + id;
        }
      },
      danger: {
        label: "No",
        className: "btn-danger"
      }
    }
  });
}


$(document).ready(function(){


  var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
$("#myBtn").click(function() {
  modal.style.display = "block";
});

// When the user clicks on <span> (x), close the modal
$(span).click(function() {
  modal.style.display = "none";
});
$("#myclose").click(function() {
  modal.style.display = "none";
});

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}


});


function showMessa() {


             // $('#dv_viewShowings').html("You do not have permission to post a showing and please update your profile by entering a credit card. Only then you will be able to access “post a showing” page.").modal("show");


           }

           function blockShowing() {
            $('#myModalBlockPost').modal("show");

          }

          function submitBlockComment(btn) {
            $btn = $(btn);
            var showing_id = $("#showing_id").val();
            var fdbck = $('.feedback').val();

            if(!showing_id){
              return false;
            }

            if(!fdbck || fdbck  == ''){
             $("#myModalBlockPost .modal-body .error-div").remove();
             $("#myModalBlockPost .modal-body #errmsg").append("<span class='error-div text-danger'>Provide feedback</span>")

             return false;
           }
           $btn.button("loading");
           $.ajax({
            url:BASE_URL+"showings/blockPost",
            type:"POST",
            data:{feedback:fdbck,showing_id:showing_id},
            dataType:"JSON",
            success:function(obj){
              $btn.button("reset");
              if(obj.status == "success"){
                $("#myModalBlockPost").modal("hide");
                window.location.href = "/home";
              }else{
                $("#myModalBlockPost .modal-body .error-div").remove();
                $("#myModalBlockPost .modal-body #errmsg").append("<span class='error-div text-danger'>"+obj.msg+"</span>")
              }
            },
            error:function(err){


            }
          });


         }

         function reviewShowing() {
           $('#myModalReviewPost').modal("show");

         }


         function submitReviewComment(btn) {
          $btn = $(btn);
          var showing_id = $("#newshowing_id").val();
          var fdbck = $('.revfeedback').val();
          var userRating = $("#input-1").val();

          if(!showing_id){
            return false;
          }

          if(!fdbck || fdbck  == ''){
            $("#myModalReviewPost .modal-body .error-div").remove();
            $("#myModalReviewPost .modal-body #errmesssg").append("<span class='error-div text-danger'>Please enter comments</span>")
            return false;
          }
          $btn.button("loading");
          $.ajax({
            url:BASE_URL+"showings/reviewPost",
            type:"POST",
            data:{feedback:fdbck,showing_id:showing_id,rating:userRating},
            dataType:"JSON",
            success:function(obj){
              $btn.button("reset");
              if(obj.status == "success"){
                $("#myModalReviewPost").modal("hide");
                //location.reload();
                window.location.href = "/home";
              }else{
                $("#myModalReviewPost .modal-body .error-div").remove();
                $("#myModalReviewPost .modal-body #errmesssg").append("<span class='error-div text-danger'>"+obj.msg+"</span>")
              }
            },
            error:function(err){


            }
          });


        }


        function errorShowing() {
         $('#myModalerrorBlock').modal("show");

       }

       function acceptedUserData(id, showing_id ) {
        var user_id = id;
        var showingId =showing_id;
        $.ajax({    
          type: "GET",
          url:BASE_URL+"showings/showingUser/"+user_id,   
          data:{id:user_id},        
        //dataType: "html",             
        success: function(html){  

         $("#acceptedUserList .modal-body").html(html);
         $('#showing_id').attr('value', showingId);
         $('#rejectShowing').attr('value', showingId);
       }

     });
        $('#acceptedUserList').modal("show");

      }

      function approveShowing() {

        var showing_id =  $('#showing_id').val();


        bootbox.dialog({
          message: "Are you sure to approve this agent",
          buttons: {
            success: {
              label: "Yes",
              className: "btn-success",
              callback: function() {
                var btn = $('#newApprove')
                btn.button('loading');

                $.ajax({    
                  type: "POST",
                  url:BASE_URL+"showings/approve/"+showing_id,   
                  data:{id:showing_id},        
                //dataType: "html",             
                success: function(html){ 
                 bootbox.dialog({
                  message: "Agent approved successfully.",
                  buttons: {
                    success: {
                      label: " OK ",
                      className: "btn-success",
                      callback: function() {
                       var btn1 = $('#newApprove')
                       btn.button('reset');

                       window.location.reload();
                     }
                   }
                 }
               });

               }

             });

              }
            },
            danger: {
              label: "No",
              className: "btn-danger"
            }
          }
        });
}


function rejectShowing() {

  var showing_id =  $('#rejectShowing').val();


  bootbox.dialog({
    message: "Are you sure to reject this agent",
    buttons: {
      success: {
        label: "Yes",
        className: "btn-success",
        callback: function() {
         var btn = $('#rejectShowing')
         btn.button('loading');

         $.ajax({    
          type: "POST",
          url:BASE_URL+"showings/reject/"+showing_id,   
          data:{id:showing_id},        
                //dataType: "html",             
                success: function(html){ 
                  bootbox.dialog({
                    message: "Agent rejected successfully.",
                    buttons: {
                      success: {
                        label: " OK ",
                        className: "btn-success",
                        callback: function() {
                          var btn1 = $('#rejectShowing')
                          btn.button('reset');
                          window.location.reload();
                        }
                      }
                    }
                  });                  

                }

              });

       }
     },
     danger: {
      label: "No",
      className: "btn-danger"
    }
  }
});
}

function viewAcceptedUserData(id, showing_id ) {
  var user_id = id;
  var showingId =showing_id;
  $('#mybutton').hide();
  $("#closebutton").css("display","block"); 



  $.ajax({    
    type: "GET",
    url:BASE_URL+"showings/showingUser/"+user_id,   
    data:{id:user_id},        
        //dataType: "html",             
        success: function(html){  

         $("#acceptedUserList .modal-body").html(html);
         $('#showing_id').attr('value', showingId);
         $('#rejectShowing').attr('value', showingId);

       }

     });
  $('#acceptedUserList').modal("show");

}
