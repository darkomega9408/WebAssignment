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

function validateText($text) {
    var nameReg = /^[^\[\]/\\()~!@#$%^&*{«»„““”‘’|\n\t….,;`^"<>'}+:?®©]*$/;
    return nameReg.test($text);
}

/**
 * Validate modal
 * @returns {boolean}
 */
function validateModal(lang,id,userName,userPwd, userRePwd , userEmail ) {
    // Validate
    var isValid = false;
    var errMsg = "";
    if( userName == "" )
        errMsg = msg[lang]["fill_in_user_name_field"];
    else if ( !validateText(userName) )
        errMsg = msg[lang]["user_name_field_allow_letters_numbers"];
    else if ( userName.length >= 25 )
        errMsg = msg[lang]["user_name_field_is_too_long"];
    else if ( userPwd == "" )
        errMsg= msg[lang]["fill_in_pass_field"];
    else if ( !validateText(userPwd) )
        errMsg = msg[lang]["pass_field_allow_letters_numbers"];
    else if ( userPwd.length >= 25 )
        errMsg = msg[lang]["pass_field_is_too_long"];
    else if ( userPwd != userRePwd )
        errMsg = msg[lang]["confirm_pass_not_match"];
    else if( userEmail == "" )
        errMsg = msg[lang]["fill_in_email_field"];
    else if ( !validateEmail(userEmail) )
        errMsg = msg[lang]["invalid_email_format"];
    else isValid = true;

    // Log error msg and return immediately if any
    $("#" + id).html(errMsg);

    return isValid;
}

