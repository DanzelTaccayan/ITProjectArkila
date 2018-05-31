$('[val-platenum]').parsley({
	maxlength: 15,
    pattern: /^[A-Za-z\-\d .()]*$/
});	

$('[val-platenum]').attr('data-parsley-required-message','Please enter a plate number.');
$('[val-platenum]').attr('data-parsley-pattern-message','Please use only letters, numbers, and hyphen.');

$('[val-van-model]').attr('data-parsley-required-message','Please enter the van model.');

$('[val-seatingcapacity]').attr('data-parsley-required-message','Please enter the seating capactiy.');