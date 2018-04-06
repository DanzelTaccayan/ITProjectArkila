
$('[val-rent-dest]').parsley({
	pattern: /^[\dA-Za-z][A-Za-z\d .,-]*[A-Za-z\d]$/,
	maxlength: 50
});

$('[name="name"]').attr('data-parsley-required-message',"Please enter a name.");

$('[val-rent-dest]').attr('data-parsley-required-message','Please enter a destination.');

$('[val-num-days]').parsley({
	range: [1,15]
});

$('[val-num-seats]').parsley({
	range: [1,4]
});

$('[val-num-days]').attr('data-parsley-required-message','Please enter a number of days.');

$('[val-num-seats]').attr('data-parsley-required-message','Please enter number of person.');

 $('[val-book-date]').parsley({
    	pattern: /^(0?[1-9]|1[0-2])\/(0?[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/
    })

    $('[val-book-date]').attr('data-parsley-pattern-message','Please enter a valid date format (mm/dd/yyyy).');
    $('[val-book-date]').attr('data-parsley-required-message','Please enter a departure date.');


    window.Parsley.addValidator('validDeparture', {
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
        en: 'Unable to depart on this date.',
      }
    });

    $('[val-book-time]').attr('data-parsley-required-message','Please enter a departure time.');

    //ANNOUNCEMENT VALIDATION
    $('[val-comment]').parsley ({
          maxlength: 300
    })

$('[val-announcement-title]').parsley({
  maxlength: 50
});

$('[val-announcement-title]').attr('data-parsley-required-message','Please enter a title.');

$('[val-announcement]').parsley({
  maxlength: 2500
});

$('[val-announcement]').attr('data-parsley-required-message','Please enter an announcement.');