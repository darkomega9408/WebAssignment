$(document).ready(function() {
    $('.login-form').submit(function(e) {
        e.preventDefault();
        var username = $('#inputUsername').val();
        var password = $('#inputPassword').val();
        $.ajax({
            url: 'php-controller/login.php',
            data: {operation: 'login', username: username, password: password},
            type: 'post',
            dataType: 'json'
        }).done(function(res) {
            if (res.status == 'login_success') {
                //alert('You have logged in succesfully');
                setCookie('token', res.token, 30);
                if (res.role == 'user') window.location = 'tree.php';
                else window.location = 'admin-page.php';
            }
        }).fail(function(err) {
            alert(err + " error");
        });
    });


    function validateEmail($email) {
        var emailReg = /^([\w_]+@([\w]+\.)+[\w]{2,4})$/;
        return emailReg.test( $email );
    }


    $("#modal-sign-up-btn").click(function (e) {
        //$("#signUp .form-horizontal").preventDefault();
        var userName = $("#signUp .userName").val();
        var userID = $("#signUp .userID").val();
        var userPassword = $("#signUp .userPassword").val();
        var userRePassword = $("#signUp .userRePassword").val();
        var userEmail = $("#signUp .userEmail").val();
        if( userName == "" || userPassword== "" ||  userPassword != userRePassword || !validateEmail(userEmail) || userEmail == "") {
            $("#signUp .error-msg").html("Some fields are invalid. Please try again!");
            return;
        }
        else $("#signUp .error-msg").html("");

        var name = $("#signUp .name").val();

        var sentData = {
            UserName:userName,
            Password: userPassword,
            Name: name,
            Email: userEmail
        };
        console.log(sentData);
        $.ajax({
            url: 'php-controller/ServerHandler.php',
            type: 'POST',
            data: {
                operation: "add",
                role : "admin",
                sentData: sentData
            },
            dataType: 'json'
        }).done(function (data) {
            $("#signUp").modal('hide');
            //alert("Sign up successfully. Now you can login and enjoy the rest !")
            console.log("Add new user successfully");

            // Auto login
            $('#inputUsername').val(userName);
            $('#inputPassword').val(userPassword);
            $('.login-form button[type="submit"]').trigger("click");

        }).fail(function () {
            console.log("Failed to add new user!")
        });
    });
});
