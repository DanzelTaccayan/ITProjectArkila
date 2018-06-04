/** TERMINAL VALIDATION **/
$('[name="addMainTerminal"]').attr('data-parsley-required-message','Please enter main terminal name.');
$('[name="mainBookingFee"]').attr('data-parsley-required-message','Please enter main terminal booking fee.');
$('[name="addTerminal"]').attr('data-parsley-required-message','Please enter destination terminal name.');
$('[val-bookingFee]').attr('data-parsley-required-message','Please enter booking fee.');
$('[val-dest-term]').attr('data-parsley-required-message','Please enter destination terminal name.');

/** TIME VALIDATION **/
$('[val-time]').attr('data-parsley-required-message','Please enter time.');
$('[val-date-req]').attr('data-parsley-required-message','Please enter date.');
$('[val-num-slot]').attr('data-parsley-required-message','Please enter number of slots.');

/** FARES VALIDATION **/
$('[val-regularFare]').attr('data-parsley-required-message','Please enter regular fare.');
$('[val-discountFare]').attr('data-parsley-required-message','Please enter discounted fare.');
$('[val-regularStFare]').attr('data-parsley-required-message','Please enter short trip regular fare.');
$('[val-discountStFare]').attr('data-parsley-required-message','Please enter short trip discounted fare.');

/** TICKET VALIDATION **/
$('[val-regularTick]').attr('data-parsley-required-message','Please enter number of regular tickets.');
$('[val-discountTick]').attr('data-parsley-required-message','Please enter number of discount tickets.');

/** FEES VALIDATION **/
$('[val-sop]').attr('data-parsley-required-message','Please enter SOP amount.');
$('[val-cf]').attr('data-parsley-required-message','Please enter community fund amount.');
