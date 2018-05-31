/** OPERATOR & DRIVER REGISTRATION VALIDATION **/
  // Validate name.
    $('[val-name]').parsley({
      maxlength: 25,
      pattern: /^[A-Za-z\-\d .()]*$/
    });	

    $('[name="firstName"]').attr('data-parsley-required-message','Please enter first name.');
    $('[name="lastName"]').attr('data-parsley-required-message','Please enter  last name.');
    $('[val-name]').attr('data-parsley-pattern-message','Please use only letters (a-z) and symbol [().-].');

    $('[val-contact]').parsley({
      maxlength: 30,
      pattern: /^[\d\(\)+-]+$/
    });

    $('[val-contact]').attr('data-parsley-pattern-message','Please use only numbers and symbols [().+].');
    $('[val-contact]').attr('data-parsley-required-message','Please enter contact number.');

  // Validate address.
    $('[val-address]').parsley({
      maxlength: 70,
    	pattern: /([A-Za-z\d ]|[\d #])[A-Za-z\d .,-]*[A-Za-z\d ]$/
    });

    $('[val-address]').attr('data-parsley-pattern-message','Please use only letters (a-z),numbers and symbols [(),.-+#].');
    $('[name="address"]').attr('data-parsley-required-message','Please enter address.');
    $('[name="provincialAddress"]').attr('data-parsley-required-message','Please enter provincial address.');


  // Validate SSS.
    $('[val-sss]').attr('data-parsley-required-message','Please enter SSS number.');

  // Validate license.

    $('[val-license]').attr('data-parsley-license-unique');
    $('[val-license]').attr('data-parsley-required-message','Please enter license number.');

  // Validate expire date.
    $('[val-license-exp]').attr('data-parsley-required-message','Please enter license expiry date.');


  // Validate contact person.
    $('[val-cname]').parsley({
      maxlength: 75,
      pattern: /^[A-Za-z\-\d .()]*$/
    });
    
    $('[val-cname]').attr('data-parsley-required-message','Please use only letters (a-z) and symbol [().-].'); 
    $('[name="contactPerson"]').attr('data-parsley-required-message','Please enter name of the contact person.');
    $('[name="contactPersonAddress"]').attr('data-parsley-required-message','Please enter address of the contact person.');
    $('[name="contactPersonContactNumber"]').attr('data-parsley-required-message','Please enter phone number of the contact person.');

    $('[val-custname]').parsley({
      maxlength: 25,
      pattern: /^[A-Za-z\-\d .()]*$/
    }); 

    $('[val-custname]').attr('data-parsley-pattern-message','Please use only letters (a-z) and symbol [().-].');