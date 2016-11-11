$(document).ready(function() {
    $('#frm_loginForm').bootstrapValidator({
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address field is required'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password field is required'
                    }
                }
            }
        }
    });

    $('#frm_registerForm').bootstrapValidator({


        fields: {
            first_name: {
                validators: {
                    notEmpty: {
                        message: 'The first name field is required'
                    }
                }
            },
            last_name: {
                validators: {
                    notEmpty: {
                        message: 'The last name field is required'
                    }
                }
            },
            phone_number: {
                validators: {
                    notEmpty: {
                        message: 'required'
                    }
                     // phone: {
                     //        country: 'US',
                     //        message: 'The value is not valid phone number'
                     //    }
                 }
             },
             
             
             license_number: {
                validators: {
                    notEmpty: {
                        message: 'The license number field is required'
                    }
                }
            },
            brokerage_firm_name: {
                validators: {
                    notEmpty: {
                        message: 'The brokerage firm name field is required'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email field is required'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            password: {
                validators: {
                     /*stringLength: {
                        min: 8,
                        message: ' gdfgdfgdfgdgfdgf'
                    },*/
                    notEmpty: {
                        message: 'The password field is required'
                    },
                    identical: {
                        field: 'password_confirmation',
                        message: 'The password and its confirm are not the same'
                    }

                }
            },
            password_confirmation: {
                validators: {

                    identical: {
                        field: 'password',
                        message: 'The password and its confirm are not the same'
                    },
                   /* stringLength: {
                        min: 8,
                        message: 'gdfgdfgdfgdgfdgf '
                    },*/
                    notEmpty: {
                        message: 'The password field is required'
                    }
                }
            },
            terms: {
                validators: {
                    choice: {
                        min: 1,
                        max: 1,
                        message: 'The terms and conditions should be checked'
                    }
                }
            }
        }
    }) ;
$('#frm_profileInfoForm').bootstrapValidator({
    fields: {
        first_name: {
            validators: {
                notEmpty: {
                    message: 'The first name field is required'
                }
            }
        },
        last_name: {
            validators: {
                notEmpty: {
                    message: 'The last name field is required'
                }
            }
        },
        phone_number: {
            validators: {
                notEmpty: {
                    message: 'Required'
                }
                  // phone: {
                  //           country: 'US',
                  //           message: 'The value is not valid phone number'
                  //       }
                  
              }
          },
          
          license_number: {
            validators: {
                notEmpty: {
                    message: 'The license number field is required'
                }
            }
        },
        brokerage_firm_name: {
            validators: {
                notEmpty: {
                    message: 'The brokerage firm name field is required'
                }
            }
        },
        email: {
            validators: {
                notEmpty: {
                    message: 'The email field is required'
                },
                emailAddress: {
                    message: 'The input is not a valid email address'
                }
            }
        },
        password: {
            validators: {
                identical: {
                    field: 'password_confirmation',
                    message: 'The password and its confirm are not the same'
                }
            }
        },
        password_confirmation: {
            validators: {
                identical: {
                    field: 'password',
                    message: 'The password and its confirm are not the same'
                }
            }
        }
    }
});

$('#frm_billingInfoForm').bootstrapValidator({
    fields: {
        bank_name: {
            validators: {
                notEmpty: {
                    message: 'The bank name field is required'
                }
            }
        },
        account_name: {
            validators: {
                notEmpty: {
                    message: 'The account name field is required'
                }
            }
        },
        routing_number: {
            validators: {
                notEmpty: {
                    message: 'The routing number field is required'
                }
            }
        },
        account_number: {
            validators: {
                notEmpty: {
                    message: 'The account number field is required'
                }
            }
        },
        account_type: {
            validators: {
                notEmpty: {
                    message: 'The account type field is required'
                }
            }
        },
        card_full_name: {
            validators: {
                notEmpty: {
                    message: 'The card full name field is required'
                }
            }
        },
        card_number: {
            validators: {
                creditCard: {
                    message: 'The credit card number is not valid'
                },
                notEmpty: {
                    message: 'The card number field is required'
                }
            }
        },
        expiry_month: {
            validators: {
                notEmpty: {
                    message: 'The expiry month field is required'
                }
            }
        },
        expiry_year: {
            validators: {
                notEmpty: {
                    message: 'The expiry year field is required'
                }
            }
        },
        cvv_number: {
            validators: {
                cvv: {
                    creditCardField: 'card_number',
                    message: 'The CVV number is not valid'
                },
                notEmpty: {
                    message: 'The cvv field is required'
                }
            }
        }
    }
});

$('#frm_bankAccountEdit').bootstrapValidator({
   live: 'enabled',
   message: 'This value is not valid',
   submitButton: '$frm_bankAccountEdit button[type="submit"]',
   submitHandler: function(validator, form, submitButton) {

    submitBankAccountInfoForm();
    return false;
},
feedbackIcons: {
  valid: 'glyphicon glyphicon-ok',
  invalid: 'glyphicon glyphicon-remove',
  validating: 'glyphicon glyphicon-refresh'
},
fields: {
    bank_name: {
        validators: {
            notEmpty: {
                message: 'The bank name field is required'
            }
        }
    },
    account_name: {
        validators: {
            notEmpty: {
                message: 'The account name field is required'
            }
        }
    },
    routing_number: {
        validators: {
            notEmpty: {
                message: 'The routing number field is required'
            },
            numeric :{
                message: 'It takes numeric value only'
            }
        }
    },
    account_number: {
        validators: {
            notEmpty: {
                message: 'The account number field is required'
            },
            numeric :{
                message: 'It takes numeric value only'
            }
        }
    },
    account_type: {
        validators: {
            notEmpty: {
                message: 'The account type field is required'
            }
        }
    }
}
});
$('#frm_creditCardEdit').bootstrapValidator({
    live: 'enabled',
    message: 'This value is not valid',
    submitButton: '$frm_creditCardEdit button[type="submit"]',
    submitHandler: function(validator, form, submitButton) {

        submitCreditCardInfoForm();
        return false;
    },
    feedbackIcons: {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
  },
  fields: {
    card_full_name: {
        validators: {
            notEmpty: {
                message: 'The card full name field is required'
            }
        }
    },
    card_number: {
        validators: {
            creditCard: {
                message: 'The credit card number is not valid'
            },
            notEmpty: {
                message: 'The card number field is required'
            }
        }
    },
    expiry_month: {
        validators: {
            notEmpty: {
                message: 'The expiry month field is required'
            }
        }
    },
    expiry_year: {
        validators: {
            notEmpty: {
                message: 'The expiry year field is required'
            }
        }
    },
    cvv_number: {
        validators: {
            cvv: {
                creditCardField: 'card_number',
                message: 'The CVV number is not valid'
            },
            notEmpty: {
                message: 'The cvv field is required'
            }
        }
    }
}
});

$('#frm_postShowingForm').bootstrapValidator({
    fields: {
        post_date: {
            validators: {
                notEmpty: {
                    message: 'The date of showing field is required'
                },
                date: {
                    dateFormat: 'mm-dd-yy',
                    message: 'The value is not a valid date'
                }
            }
        },
        start_time: {
            validators: {
                notEmpty: {
                    message: 'The earliest start time field is required'
                }
            }
        },
        end_time: {
            validators: {
                notEmpty: {
                    message: 'The latest start time field is required'
                }
            }
        }


    }
});

runValidationFunctionJquery();

$('form input').on('keyup blur', function () { // fires on every keyup & blur
    console.log($('#frm_postShowingForm').valid());
        if ($('#frm_postShowingForm').valid()) {                   // checks form for validity
            $('.btn').prop('disabled', false);        // enables button
        } else {
            $('.btn').prop('disabled', 'disabled');   // disables button
        }
    });

});

// function runValidationFunction(){
//     $('#frm_postShowingForm').bootstrapValidator({
//         fields: {
//             post_date: {
//                 validators: {
//                     notEmpty: {
//                         message: 'The date of showing field is required'
//                     },
//                     date: {
//                         dateFormat: 'mm-dd-yy',
//                         message: 'The value is not a valid date'
//                     }
//                 }
//             },
//             start_time: {
//                 validators: {
//                     notEmpty: {
//                         message: 'The earliest start time field is required'
//                     }
//                 }
//             },
//             end_time: {
//                 validators: {
//                     notEmpty: {
//                         message: 'The latest start time field is required'
//                     }
//                 }
//             },
//             customer_name: {
//                 validators: {
//                     notEmpty: {
//                         message: 'The customer name field is required'
//                     }
//                 }
//             },
//             customer_email: {
//                 validators: {
//                     notEmpty: {
//                         message: 'The customer email field is required'
//                     },
//                     emailAddress: {
//                         message: 'The input is not a valid email address'
//                     }
//                 }
//             },
//             customer_phone_number: {
//                 validators: {
//                     notEmpty: {
//                         message: 'The customer phone number field is required'
//                     }
//                 }
//             },

//             house_count: {
//                 validators: {
//                     notEmpty: {
//                         message: 'The house count field is required'
//                     }
//                 }
//             },
//             'address[]': {
//                 validators: {
//                     notEmpty: {
//                         message: 'The address field is required'
//                     }
//                 }
//             },
//             'unit_number[]': {
//                 validators: {
//                     empty: {
//                         message: ''
//                     }
//                 }
//             },

//             'state[]': {
//                 validators: {
//                     notEmpty: {
//                         message: 'The State field is required'
//                     }
//                 }
//             },
//             'city[]': {
//                 validators: {
//                     notEmpty: {
//                         message: 'The City field is required'
//                     }
//                 }
//             },
//             'zip[]': {
//                 validators: {
//                     notEmpty: {
//                         message: 'The Zip field is required'
//                     }
//                 }
//             },
//             'MLS_number[]': {
//                 validators: {
//                     notEmpty: {
//                         message: 'The MLS number field is required'
//                     }
//                 }
//             }

//         }
//     });
// }

function runValidationFunctionJquery(){

       $('#frm_postShowingForm').validate({ // initialize plugin within DOM ready
        
           invalidHandler: function(form, validator) {
            if (validator.numberOfInvalids() > 0) {
             $('.collapse').collapse('show');
         }
     },
     ignore: false,
     rules: {

            // post_date: {
            //     required: true
            // },
            //  start_time: {
            //     required: true
            // },
            //  end_time: {
            //     required: true
            // },
            customer_name: {
                required: true
            },
            customer_email: {
                required: true,
                email: true

            },
            
            customer_phone_number: {
                required: true,
                phoneUS: true

                
            },
            house_count: {
                required: true
            },
            'address[]': {
                required: true
            },
            //  'unit_number[]': {
            //     required: true
            // },
            'state[]': {
                required: true
            },
            'city[]': {
                required: true
            },
            'MLS_number[]': {
                required: true,
                number: true
            },


            
            
        },
        messages: {
            post_date:"The post date field is required.",
            
            customer_phone_number:{
                required:"The customer phone field is required",
                phoneUS:"The customer phone field is required"
            },
            'address[]':"The address field is required.",
      //   'unit_number[]':"The unit number field is required.",
      'state[]':"The state field is required.",
      'city[]':"The city field is required.",
      'MLS_number[]':{
        required :"The MLS number field is required.",
        number:"The MLS number field is numeric."
    },
    customer_name: "The customer Name field is required.",
    customer_email: {
        required: "The email field is required.",
        email: ""
        
    }
},
});
}










$(document).ready(function() {

    jQuery.validator.addMethod('phoneUS', function(phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, ''); 
        return this.optional(element) || phone_number.length > 9 &&
        phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
    }, 'Please enter a valid phone number.');

    $('.input-group input[required], .input-group textarea[required], .input-group select[required]').on('keyup, change', function() {
        var $group = $(this).closest('.input-group'),
        $addon = $group.find('.input-group-addon'),
        $icon = $addon.find('span'),
        state = false;

        if (!$group.data('validate')) {
            state = $(this).val() ? true : false;
        }else if ($group.data('validate') == "email") {
            state = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val())
        }else if($group.data('validate') == 'phone') {
            state = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/.test($(this).val())
        }else if ($group.data('validate') == "length") {
            state = $(this).val().length >= $group.data('length') ? true : false;
        }else if ($group.data('validate') == "number") {
            state = !isNaN(parseFloat($(this).val())) && isFinite($(this).val());
        }

        if (state) {
            $addon.removeClass('danger');
            $addon.addClass('success');
            $icon.attr('class', 'glyphicon glyphicon-ok');
        }else{
            $addon.removeClass('success');
            $addon.addClass('danger');
            $icon.attr('class', 'glyphicon glyphicon-remove');
        }
    });


});


// $('.newsubmit').click(function(e){

//     e.preventDefault();
//     var sectionValid = true;
//     var collapse = $(this).closest('.panel-group.collapse');
//        console.log(this);
//     $.each(collapse.find('input, select, textarea'), function(){

//         if(!$(this).valid()){
//             sectionValid = false;
//         }
//     });
//     if(sectionValid){
//         collapse.collapse('toggle');
//         collapse.parents('.panel').next().find('.panel-group.collapse').collapse('toggle');
//     }
// });