/**
 * Created by VINH on 4/18/2016.
 */

/**
 * Validate email
 * @param $email
 * @returns {boolean}
 */
function validateEmail($email) {
    var emailReg = /^([\w_]+@([\w]+\.)+[\w]{2,4})$/;
    return emailReg.test( $email );
}

/**
 * Validate modal
 * @returns {boolean}
 */
function validateModal(modal,userName,userPwd, userRePwd , userEmail ) {
    // Validate
    var isValid = false;
    var errMsg = "";
    if( userName == "" )
        errMsg = "Please fill in 'User Name' field";
    else if ( userPwd == "" )
        errMsg= "Please fill in 'Password' field";
    else if ( userPwd != userRePwd )
        errMsg = "The confirmation password does not match the password you first entered";
    else if( userEmail == "" )
        errMsg = "Please fill in 'Email' field";
    else if ( !validateEmail(userEmail) )
        errMsg = "Invalid email";
    else isValid = true;

    // Log error msg and return immediately if any
    $("#" + modal +" .error-msg").html(errMsg);

    return isValid;
}
