/** OPERATOR & DRIVER REGISTRATION VALIDATION **/
  // Validate name.
    $('[val-name]').parsley({
      maxlength: 30,
      pattern: /^[a-zA-Z]$|^[a-zA-Z][a-zA-Z\s-]*[a-zA-Z]$/,
      minlength: 2
    });	

    $('[name="firstName"]').attr('data-parsley-required-message','Please enter a first name.');
    $('[name="lastName"]').attr('data-parsley-required-message','Please  enter a last name.');
    $('[val-name]').attr('data-parsley-pattern-message','Please use letters (a-z) only.');

    $('[name="fathersName"]').attr('data-parsley-required-message','Please  enter a father\'s name.');
  // Validate contact number.
    $('[val-phone]').parsley({
      pattern: /\d{3}-\d{3}-\d{4}$/
    });

    $('[val-phone]').attr('data-parsley-pattern-message','Please enter a valid phone number.');
    $('[val-phone]').attr('data-parsley-required-message','Please enter a phone number.');

  // Validate address.
    $('[val-address]').parsley({
    	pattern: /^(?!.* {2})(?=\S)(?=.*\S$)[a-zA-Z0-9\s-]+$/,
    	maxlength: 100
    });
    $('[val-address]').attr('data-parsley-pattern-message','Please  use only letters (a-z) and numbers.');
    $('[name="address"]').attr('data-parsley-required-message','Please enter an address.');
    $('[name="provincialAddress"]').attr('data-parsley-required-message','Please enter a provincial address.');

  // Validate birth date.
    $('[val-birthdate]').parsley({
    	pattern: /^(0?[1-9]|1[0-2])\/(0?[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/
    });
    $('[val-birthdate]').attr('data-parsley-pattern-message','Please enter a valid date format (mm/dd/yyyy).');
    $('[val-birthdate]').attr('data-parsley-required-message','Please enter a birth date.');

    window.Parsley.addValidator('legalAge', {
      validateString: function(value) {
      	var bdate_array = value.split('/')
      	var now = new Date();
      	var nowMonth = (now.getMonth() + 1);
      	var valueMonth = parseInt(bdate_array[0]);
    	var nowDay = now.getDate();
    	var valueDay = parseInt(bdate_array[1]);
    	var sumYear = now.getFullYear() - parseInt(bdate_array[2]);
        if ((sumYear > 18) || (sumYear === 18 && ((nowMonth > valueMonth) || (nowMonth === valueMonth && nowDay >= valueDay) ) )) {
        	return true;
        } else {
        	return false;
        }
      },
      messages: {
        en: 'Age must be 18 and above.',
      }
    });

  // Validate birth place.
    $('[val-birthplace]').parsley({
    	pattern: /^[a-zA-Z]$|^[a-zA-Z][a-zA-Z\s-]*[a-zA-Z]$/,
    	maxlength: 35
    });
    $('[val-birthplace]').attr('data-parsley-pattern-message','Please use only letters (a-z) and numbers.');
    $('[val-birthplace]').attr('data-parsley-required-message','Please enter a birthplace.');


  // Validate citizenship.
    $('[val-citizenship]').parsley({
    	maxlength: 25,
    	pattern: /^[a-zA-Z]+$/
    });
    $('[val-citizenship]').attr('data-parsley-required-message','Please enter a citizenship.');
    $('[val-citizenship]').attr('data-parsley-pattern-message','Please use letters only (a-z).');

  // Validate SSS.
    $('[val-sss]').parsley({
    	maxlength: 10
    });
    $('[val-sss]').attr('data-parsley-required-message','Please enter a SSS number.');

  // Validate license.
    $('[val-license]').parsley({
    	maxlength: 11
    });

    $('[val-license]').attr('data-parsley-license-unique');
    $('[val-license]').attr('data-parsley-required-message','Please enter a license number.');

  // Validate expire date.
    $('[val-license-exp]').parsley({
    	pattern: /^(0?[1-9]|1[0-2])\/(0?[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/
    })

    $('[val-license-exp]').attr('data-parsley-pattern-message','Please enter a valid date format (mm/dd/yyyy).');
    $('[val-license-exp]').attr('data-parsley-required-message','Please enter an expire date.');


    window.Parsley.addValidator('expireDate', {
      validateString: function(value) {
      	var bdate_array = value.split('/')
      	var now = new Date()
      	var nowMonth = (now.getMonth() + 1);
      	var valueMonth = parseInt(bdate_array[0]);
    	var nowDay = now.getDate();
    	var valueDay = parseInt(bdate_array[1]);
    	var nowYear = now.getFullYear(); 
    	var valueYear = parseInt(bdate_array[2]);
        if(valueYear > nowYear || (valueYear === nowYear && ((valueMonth > nowMonth) || (valueMonth === nowMonth && valueDay > nowDay)) ) ){
        	return true;
        } else {
        	return false;
        }
      },
      messages: {
        en: 'The license has already expired',
      }
    });

  // Validate spouse
    $('[name="nameOfSpouse"]').attr('data-parsley-required-message','Please enter name of spouse.');
    $('[name="spouseBirthDate"]').attr('data-parsley-required-message','Please enter birth date of spouse.');
    $('[val-spouse-bdate]').parsley({
      pattern: /^(0?[1-9]|1[0-2])\/(0?[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/
    });

    $('[val-spouse-date]').attr('data-parsley-pattern-message','Please enter a valid date format (mm/dd/yyyy).');
    $(document).ready(function() {
        $('#regForm').parsley();
        $('select[name="civilStatus"]').on('change', function() {
            
            if ($(this).val() === 'married') {
                $('[name="nameOfSpouse"').attr('data-parsley-required', 'true').parsley();
                $('[name="spouseBirthDate"]').attr('data-parsley-required', 'true').parsley();
            } 
        });
    });
    //Validate name
    $('[val-fullname]').parsley({
      maxlength: 50
    });


    // Validate occupation
    $('[val-occupation]').parsley({
      maxlength: 30
    });


  // Validate contact person.
    $('[name="contactPerson"]').attr('data-parsley-required-message','Please enter name of the contact person.');
    $('[name="contactPersonAddress"]').attr('data-parsley-required-message','Please enter address of the contact person.');
    $('[name="contactPersonContactNumber"]').attr('data-parsley-required-message','Please enter phone number of the contact person.');

    
