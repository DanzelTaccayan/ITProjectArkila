
$('[val-date-depart]').parsley({
    	pattern: /^(0?[1-9]|1[0-2])\/(0?[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/
    });

$('[val-date-depart]').attr('data-parsley-pattern-message','Please enter a valid date format (mm/dd/yyyy).');
$('[val-date-depart]').attr('data-parsley-required-message','Please enter the date of depature.');

$('[val-time-depart]').attr('data-parsley-required-message','Please enter the time of departure.');


$('[val-report-discount]').parsley({
    	min: 0
});


window.Parsley.addValidator('departureReport', {
      validateString: function(value) {
        var date_array = value.split('/')
        var now = new Date()
        var nowMonth = (now.getMonth() + 1);
        var valueMonth = parseInt(date_array[0]);
      var nowDay = now.getDate();
      var valueDay = parseInt(date_array[1]);
      var nowYear = now.getFullYear(); 
      var valueYear = parseInt(date_array[2]);
        if(valueYear < nowYear || (valueYear === nowYear && ((valueMonth < nowMonth) || (valueMonth === nowMonth && valueDay <= nowDay)) ) ){
          return true;
        } else {
          return false;
        }
      },
      messages: {
        en: 'Departure date should be today or before',
      }
    });