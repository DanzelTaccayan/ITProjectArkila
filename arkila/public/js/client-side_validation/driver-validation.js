    $('[val-cpassword]').attr('data-parsley-required-message','Please enter old password.');
    $('[val-npassword]').attr('data-parsley-required-message','Please enter new password.');
    $('#confirmPassword').attr('data-parsley-equalto','#newPassword');
    $('#confirmPassword').attr('data-parsley-equalto-message','Password does not match.');