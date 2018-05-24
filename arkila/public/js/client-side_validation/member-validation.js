/** OPERATOR & DRIVER REGISTRATION VALIDATION **/
  // Validate name.
    $('[val-name]').parsley({
      maxlength: 25,
      pattern: /^[A-Za-z\-\d .()]*$/
    });	

    $('[name="firstName"]').attr('data-parsley-required-message','Please enter a first name.');
    $('[name="lastName"]').attr('data-parsley-required-message','Please  enter a last name.');
    $('[val-name]').attr('data-parsley-pattern-message','Please use only letters (a-z) and symbol [().-].');

    $('[val-phone]').parsley({
      maxlength: 30,
      pattern: /^[\d\(\)+-]+$/
    });

    $('[val-phone]').attr('data-parsley-pattern-message','Please use only numbers and symbols [().-+].');
    $('[val-phone]').attr('data-parsley-required-message','Please enter a phone number.');

  // Validate address.
    $('[val-address]').parsley({
      maxlength: 70,
    	pattern: /([A-Za-z\d ]|[\d #])[A-Za-z\d .,-]*[A-Za-z\d ]$/
    });

    $('[val-address]').attr('data-parsley-pattern-message','Please use only letters (a-z),numbers and symbols [(),.-+#].');
    $('[name="address"]').attr('data-parsley-required-message','Please enter an address.');
    $('[name="provincialAddress"]').attr('data-parsley-required-message','Please enter a provincial address.');


  // Validate SSS.
    $('[val-sss]').parsley({
    });

    $('[val-sss]').attr('data-parsley-pattern-message','Please enter a valid SSS number format.');
    $('[val-sss]').attr('data-parsley-required-message','Please enter a SSS number.');

  // Validate license.
    $('[val-license]').parsley({
    });

    $('[val-license]').attr('data-parsley-pattern-message', 'Please enter a valid license number format');
    $('[val-license]').attr('data-parsley-license-unique');
    $('[val-license]').attr('data-parsley-required-message','Please enter a license number.');

  // Validate expire date.
    $('[val-license-exp]').parsley({
    })

    $('[val-license-exp]').attr('data-parsley-pattern-message','Please enter a valid date format (mm/dd/yyyy).');
    $('[val-license-exp]').attr('data-parsley-required-message','Please enter an expire date.');

    //Validate name
    $('[val-fullname]').parsley({
      maxlength: 75,
      pattern: /^[A-Za-z\-\d .()]*$/
    });

    $('[val-fullname]').attr('data-parsley-pattern-message','Please use letters (a-z) only.');

  // Validate contact person.
    $('[name="contactPerson"]').attr('data-parsley-required-message','Please enter name of the contact person.');
    $('[name="contactPersonAddress"]').attr('data-parsley-required-message','Please enter address of the contact person.');
    $('[name="contactPersonContactNumber"]').attr('data-parsley-required-message','Please enter phone number of the contact person.');