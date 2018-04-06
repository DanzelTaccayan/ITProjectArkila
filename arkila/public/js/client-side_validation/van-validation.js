$('[val-platenum]').parsley({
    minlength: 6,
	maxlength: 9,
    pattern: /^[A-Z\d]+$|^([A-Z\d])+[-]([A-Z\d])+$/
});	

$('[val-platenum]').attr('data-parsley-required-message','Please enter a plate number.');
$('[val-platenum]').attr('data-parsley-pattern-message','Please use only uppercase letters (A-Z), numbers, and hyphen.');

$('[val-van-model]').parsley({
	maxlength: 30
});	

$('[val-van-model]').attr('data-parsley-required-message','Please enter the van model.');

$('[val-seatingcapacity]').parsley({		
	range: [10,15]
});	