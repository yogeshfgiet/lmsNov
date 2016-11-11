/* 
 * It will have all js functionality related to users
 */



 $(window).load(function() {
    $('.nbtn').prop('disabled',true);

});
 $('#user_type').change(function() {
    $('.nbtn').prop('disabled',false);
});

 /* AJAX Request for submit Credit Card and Bank Accont information */

 function submitCreditCardInfoForm() {
    var url = "edit-payment-profile"; // the script where you handle the form input.
    $('body').loader('show');

            $.ajax({
            type: "POST",
            url: url,
           data: $("#frm_creditCardEdit").serialize(), // serializes the form's elements.
           success: function(data)
           {
              var json = JSON.parse(data);   

              if(json.msg){
               $('#NmsgDiv').show();
               $('#NmsgDiv').css('color', '#a94442');
               $('#NmsgDiv').html(json.msg);
               setTimeout(function() {
                   $('#NmsgDiv').fadeOut('fast');
               }, 4000);
               $('body').loader('hide');
               return false;
           }

           if (json.card_full_name){
               $('#NmsgDiv').show();
               $('#NmsgDiv').css('color', '#a94442');
               $('#NmsgDiv').html(json.card_full_name);
               setTimeout(function() {
                   $('#NmsgDiv').fadeOut('fast');
               }, 4000);

           }
           else if (json.card_number){
            $('#NmsgDiv').show();
            $('#NmsgDiv').css('color', '#a94442');
            $('#NmsgDiv').html(json.card_number);
            setTimeout(function() {
               $('#NmsgDiv').fadeOut('fast');
           }, 4000);

        }
        else if(json.expiry_month){
         $('#NmsgDiv').show();
         $('#NmsgDiv').css('color', '#a94442');
         $('#NmsgDiv').html(json.expiry_month);
         setTimeout(function() {
           $('#NmsgDiv').fadeOut('fast');
       }, 4000);


     }
     else if(json.expiry_year){
         $('#NmsgDiv').show();
         $('#NmsgDiv').css('color', '#a94442');
         $('#NmsgDiv').html(json.expiry_year);
         setTimeout(function() {
           $('#NmsgDiv').fadeOut('fast');
       }, 4000);


     }

     else if(json.cvv_number){
         $('#NmsgDiv').show();
         $('#NmsgDiv').css('color', '#a94442');
         $('#NmsgDiv').html(json.cvv_number);
         setTimeout(function() {
           $('#NmsgDiv').fadeOut('fast');
       }, 4000);

     }


     else if(data == 'true' ){

        $('#NSmsgDiv').show();
        $('#NSmsgDiv').css('color', '#3c763d');
        $('#NSmsgDiv').html("Information has been saved successfully!!");
        setTimeout(function() {
           $('#NSmsgDiv').fadeOut('fast');
       }, 4000);
    }
    else if(data == 'false'){
        $('#NmsgDiv').show();
        $('#NmsgDiv').css('color', '#a94442');
        $('#NmsgDiv').html("Information incorrect.");
        setTimeout(function() {
           $('#NmsgDiv').fadeOut('fast');
       }, 4000);
    }

    $('body').loader('hide');
}
});

    
}

 //$('#frm_bankAccountEdit').unbind('submit').bind('submit',function(e) {
     function submitBankAccountInfoForm() { 
        $('#loading').loader('show');

    var url = "edit-payment-profile"; // the script where you handle the form input.
    
            $.ajax({
            type: "POST",
            url: url,
            data: $("#frm_bankAccountEdit").serialize(), // serializes the form's elements.
            success: function(data)
            {
                var json = JSON.parse(data);
                if(json.msg){
                 $('#msgDiv').show();
                 $('#msgDiv').css('color', '#a94442');
                 $('#msgDiv').html(json.msg);
                 setTimeout(function() {
                     $('#msgDiv').fadeOut('fast');
                 }, 4000);
                 $('#loading').loader('hide');
                 return false;
                }  
              
              if (json.bank_name){
                $('#msgDiv').show();
                $('#msgDiv').css('color', '#a94442');
                $('#msgDiv').html(json.bank_name);
                setTimeout(function() {
                 $('#msgDiv').fadeOut('fast');
                    }, 4000);

                }
            else if (json.account_name){
             $('#msgDiv').show();
             $('#msgDiv').css('color', '#a94442');
             $('#msgDiv').html(json.account_name);
             setTimeout(function() {
                 $('#msgDiv').fadeOut('fast');
             }, 4000);

            }
            else if(json.routing_number){
           $('#msgDiv').show();
           $('#msgDiv').css('color', '#a94442');
           $('#msgDiv').html(json.routing_number);
           setTimeout(function() {
             $('#msgDiv').fadeOut('fast');
            }, 4000);


        }
       else if(json.account_number){
           $('#msgDiv').show();
           $('#msgDiv').css('color', '#a94442');
           $('#msgDiv').html(json.account_number);
           setTimeout(function() {
             $('#msgDiv').fadeOut('fast');
         }, 4000);


       }
       else if(json.account_type){
           $('#msgDiv').show();
           $('#msgDiv').css('color', '#a94442');
           $('#msgDiv').html(json.account_type);
           setTimeout(function() {
             $('#msgDiv').fadeOut('fast');
         }, 4000);


       }
       else if(data == 'true' ){

        $('#SmsgDiv').show();
        $('#SmsgDiv').css('color', '#3c763d');
        $('#SmsgDiv').html("Information has been saved successfully!!");
        setTimeout(function() {
         $('#SmsgDiv').fadeOut('fast');
     }, 4000);
    }
    else if(data == 'false'){
     $('#msgDiv').css('color', '#a94442');
     $('#msgDiv').html("Information incorrect .");
     setTimeout(function() {
         $('#msgDiv').fadeOut('fast');
     }, 4000);
 }

 $('#loading').loader('hide');

}
});


}

/* End AJAX request */

 $(function () {
    $('.collapse').on('shown.bs.collapse', function () {
        $(this).parent().find(".glyphicon-plus")
        .removeClass("glyphicon-plus").addClass("glyphicon-minus");
    }).on('hidden.bs.collapse', function () {
        $(this).parent().find(".glyphicon-minus")
        .removeClass("glyphicon-minus").addClass("glyphicon-plus");
    });

    if ($('#frm_profileInfoForm').is(':visible')) {
        changeUserType('profile-info');
    }
});
 window.onload = changeUserType('profile-info');
 
 function showRegistration() {
    var selectedVal = $('#sel_serviceSubscriber option:selected').val();

    if (0 === parseInt(selectedVal)) {
        $('#dv_registrationConfirm').removeClass('show').addClass('hide');
        $('#dv_registrationFailure').removeClass('hide').addClass('show');
    } else {
        $('#dv_registrationConfirm').removeClass('show').addClass('hide');
        $('#dv_registration').removeClass('hide').addClass('show');
    }
}

function uploadImageFile() {
    $('#dv_loaderImage').css('display', 'block');
    $('#frm_changeProfilePic').submit();
}

function changeProfileImage(imgName) {
    $('.navbar-right .dropdown img', window.parent.document).attr('src', imgName);
}

function changeUserType(sectionName) {
    var selectedType = $('#user_type option:selected').val();

    $('.user-types').each(function( index) {
        $( this ).val(selectedType);


    });


    switch(parseInt(selectedType)) {

        case 1:

        $('#dv_bankInfoLnk, #dv_bankInfo').addClass('hide');
        $('#dv_bankInfoLnk :input').addClass('ignore');
        $('#dv_cardInfoLnk :input').removeClass('ignore');
        $('#dv_cardInfoLnk, #dv_cardInfo').removeClass('hide');
        $("#user_type option[value=" + 2 + "]").hide();
        $("#user_type option[value=" + 1 + "]").addClass('selected');

        if ('more-info' === sectionName) {
            $('#dv_cardInfoLnk .glyphicon').addClass('glyphicon-minus')
            .removeClass('glyphicon-plus');
            $('#collapseTwo').addClass('in').attr('aria-expanded', 'true').removeAttr('style');
        }

        break;

        case 2:
        $('#dv_cardInfoLnk, #dv_cardInfo').addClass('hide');
        $('#dv_cardInfoLnk :input').addClass('ignore');
        $('#dv_bankInfoLnk :input').removeClass('ignore');
        $('#dv_bankInfoLnk, #dv_bankInfo').removeClass('hide');
        $("#user_type option[value=" + 1 + "]").hide(); 
        $("#user_type option[value=" + 2 + "]").addClass('newselected');

        $("#user_type option:selected").show();   
        if ('more-info' === sectionName) {
            $('#dv_bankInfoLnk .glyphicon').addClass('glyphicon-minus')
            .removeClass('glyphicon-plus');
            $('#collapseOne').addClass('in').attr('aria-expanded', 'true').removeAttr('style');
        }

        break;

        case 3:
        $('#dv_cardInfoLnk, #dv_cardInfo').removeClass('hide');
        $('#dv_bankInfoLnk, #dv_bankInfo').removeClass('hide');
        $('#dv_bankInfoLnk :input').removeClass('ignore');
        $('#dv_cardInfoLnk :input').removeClass('ignore');

        $("#user_type option[value=" + 1 + "]").hide();  
        $("#user_type option[value=" + 2 + "]").hide();  
        $(".selected").show();  
        $(".newselected").show();  




        if ('more-info' === sectionName) {
            $('#dv_cardInfoLnk .glyphicon').addClass('glyphicon-plus')
            .removeClass('glyphicon-minus');
            $('#collapseTwo').removeClass('in').attr('aria-expanded', 'false');

            $('#dv_bankInfoLnk .glyphicon').addClass('glyphicon-minus')
            .removeClass('glyphicon-plus');
            $('#collapseOne').addClass('in').attr('aria-expanded', 'true').removeAttr('style');
        }

        break;
    }
}


//Functionality for choose user type when user login first time .
var site_url  = window.location.href;  
var base_urll= window.location.origin;
var current_url = base_urll.concat('/billing-info')
$(function(){
  if (current_url==site_url){
     changeUserTypeBilling('profile-info');
 }
});



function changeUserTypeBilling(sectionName) {
    var selectedType = $('#user_type option:selected').val();

    $('.user-types').each(function( index) {
        $( this ).val(selectedType);


    });


    switch(parseInt(selectedType)) {

        case 1:
        $('#dv_bankInfoLnk, #dv_bankInfo').addClass('hide');
        $('#dv_bankInfoLnk :input').addClass('ignore');
        $('#dv_cardInfoLnk :input').removeClass('ignore');
        $('#dv_cardInfoLnk, #dv_cardInfo').removeClass('hide');
        $("#user_type option[value=" + 2 + "]").show();
        $("#user_type option[value=" + 1 + "]").addClass('selected');

        if ('more-info' === sectionName) {
            $('#dv_cardInfoLnk .glyphicon').addClass('glyphicon-minus')
            .removeClass('glyphicon-plus');
            $('#collapseTwo').addClass('in').attr('aria-expanded', 'true').removeAttr('style');
        }

        break;

        case 2:
         
        $('#dv_cardInfoLnk, #dv_cardInfo').addClass('hide');
        $('#dv_cardInfoLnk :input').addClass('ignore');
        $('#dv_bankInfoLnk :input').removeClass('ignore');
        $('#dv_bankInfoLnk, #dv_bankInfo').removeClass('hide');
        $("#user_type option[value=" + 1 + "]").show(); 
        $("#user_type option[value=" + 2 + "]").addClass('newselected');

        $("#user_type option:selected").show();   
        if ('more-info' === sectionName) {
            $('#dv_bankInfoLnk .glyphicon').addClass('glyphicon-minus')
            .removeClass('glyphicon-plus');
            $('#collapseOne').addClass('in').attr('aria-expanded', 'true').removeAttr('style');
        }

        break;

        case 3:
          
        $('#dv_cardInfoLnk, #dv_cardInfo').removeClass('hide');
        $('#dv_bankInfoLnk, #dv_bankInfo').removeClass('hide');
        $('#dv_bankInfoLnk :input').removeClass('ignore');
        $('#dv_cardInfoLnk :input').removeClass('ignore');

        $("#user_type option[value=" + 1 + "]").show();  
        $("#user_type option[value=" + 2 + "]").show();  
        $(".selected").show();  
        $(".newselected").show();  




        if ('more-info' === sectionName) {
            $('#dv_cardInfoLnk .glyphicon').addClass('glyphicon-plus')
            .removeClass('glyphicon-minus');
            $('#collapseTwo').removeClass('in').attr('aria-expanded', 'false');

            $('#dv_bankInfoLnk .glyphicon').addClass('glyphicon-minus')
            .removeClass('glyphicon-plus');
            $('#collapseOne').addClass('in').attr('aria-expanded', 'true').removeAttr('style');
        }

        break;
    }
}