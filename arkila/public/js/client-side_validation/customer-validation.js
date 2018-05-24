$('[val-name]').parsley({
      maxlength: 30,
      pattern: /^[A-Za-z\-\d .()]*$/,
      minlength: 2
 });	

$('[name="first_name"]').attr('data-parsley-required-message','Please enter a first name.');
$('[name="last_name"]').attr('data-parsley-required-message','Please  enter a last name.');
$('[val-name]').attr('data-parsley-pattern-message','Please use only letters (a-z) and symbol [().-].').parsley({
  maxlength: 15,
  pattern: /^[\dA-Za-z][A-Za-z\d.-]*[A-Za-z\d]$/,
  minlength: 6
});

$('[name="username"]').attr('data-parsley-required-message','Please enter a username');
$('[val-username]').attr('data-parsley-pattern-message','Username should only contain letters, numbers, periods, and hyphen');


$('[name="email"]').attr('data-parsley-required-message','Please enter an email');

$('[val-password]').parsley({
  maxlength: 15,
  minlength: 8
});

$('[val-password]').attr('data-parsley-required-message','Password is required');
$('[name="password_confirmation"]').attr('data-parsley-equalto','#customerPassword');
$('[name="password_confirmation"]').attr('data-parsley-equalto-message','Password does not match');