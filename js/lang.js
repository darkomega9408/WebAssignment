$(document).ready(function() {
  $('.language li:not(.active)').click(function() {
      setCookie('lang', $(this).attr('data-lang'), 30);
      console.warn('haha');
      document.location.reload();
  });
});

var msg = {
    en:{
        fill_in_user_name_field : "Please fill in 'User Name' field",
        fill_in_pass_field: "Please fill in 'Password' field",
        fill_in_email_field: "Please fill in 'Email' field",
        fill_in_name_field: "Please fill in 'Name' field",
        invalid_email_format: "Invalid email format",
        name_field_allow_letters_numbers : "'Name' field only allowed letters and numbers",
        user_name_field_allow_letters_numbers: "'User Name' field only allowed letters and numbers",
        pass_field_allow_letters_numbers: "'Password' field only allowed letters and numbers",
        birth_place_field_allow_letters_numbers: "'Password' field only allowed letters and numbers",
        confirm_pass_not_match : "The confirmation password does not match the password you first entered",
        user_or_pass_incorrect: "User name or password is incorrect",
        user_already_exist: "User already existed. Please try new username or email instead!",
        fill_in_birth_place_field:"Please fill in 'BirthPlace' field",
        child_can_not_old_than_parent:"Child can't be older than parent",
        user_name_field_is_too_long: "'User name' must be less than 25 characters",
        pass_field_is_too_long: "'Password' must be less than 25 characters",
        name_field_is_too_long: "'Name' must be less than 25 characters",
        email_field_is_too_long: "'Email' must be less than 25 characters",
        birthplace_field_is_too_long: "'Birthplace' must be less than 25 characters"
    },
    vi:{
        fill_in_user_name_field : "Hãy nhập vào 'Tên người dùng'",
        fill_in_pass_field: "Hãy nhập vào 'Mật khẩu'",
        fill_in_email_field: "Hãy nhập vào Email'",
        fill_in_name_field: "Hãy nhập vào 'Tên'",
        invalid_email_format: "Định dạng email không đúng",
        name_field_allow_letters_numbers: "'Name' chỉ được chứa kí tự và số",
        user_name_field_allow_letters_numbers: "'Tên người dùng' chỉ được chứa kí tự và số",
        pass_field_allow_letters_numbers: "'Mật khẩu' chỉ được chứa kí tự và số",
        confirm_pass_not_match : "Mật khẩu nhập lại không trùng khớp",
        user_or_pass_incorrect: "Tài khoản và mật khẩu không trùng khớp",
        user_already_exist: "Tài khoản đã tồn tại. Bạn hãy sử dụng tài khoản hay email khác!",
        fill_in_birth_place_field: "Hãy nhập vào 'Nơi sinh'",
        child_can_not_old_than_parent: "Con không thể lớn hơn bố/mẹ",
        birth_place_field_allow_letters_numbers: "'Nơi sinh' chỉ được chứa kí tự và số",
        user_name_field_is_too_long: "'Tên người dùng' dưới 25 kí tự",
        pass_field_is_too_long:"'Mật khẩu' dưới 25 kí tự",
        email_field_is_too_long: "'Email' dưới 25 kí tự",
        birthplace_field_is_too_long: "'Nơi sinh' dưới 25 kí tự",
        name_field_is_too_long: "'Tên' dưới 25 kí tự"
    }
};
