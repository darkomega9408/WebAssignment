$(document).ready(function(){
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
            $('#modal-uploading').modal('hide');
            $('#warning').text('');
            if (res.status == 'login_success') {
                setCookie('token', res.token, 30);
                if (res.role == 'user' || res.role == 'guest')
                    document.location.href = 'tree.php';
                else document.location.href = 'admin-page.php';
                console.log(document.location.href);
            }
            else if (res.status == 'user_not_found') {
                $('#warning').html('<i class="fa fa-fw fa-exclamation-circle fa-2x"></i><span>Username or password is incorrect</span>');
            }
        }).fail(function(err) {
            $('#modal-uploading').modal('hide');
            console.log(err);
        });
    });

    

    $("#modal-sign-up-btn").click(function (e) {
        //$("#signUp .form-horizontal").preventDefault();
        var userName = $("#signUp .userName").val();
        var userID = $("#signUp .userID").val();
        var userPassword = $("#signUp .userPassword").val();
        var userRePassword = $("#signUp .userRePassword").val();
        var userEmail = $("#signUp .userEmail").val();

        // Validate step here
        if ( !validateModal("signUp",userName,userPassword,userRePassword,userEmail) )
            return;

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
			$('#modal-uploading').modal('hide');
            $("#signUp").modal('hide');
            //alert("Sign up successfully. Now you can login and enjoy the rest !")
            console.log("Add new user successfully");

            // Auto login
            $('#inputUsername').val(userName);
            $('#inputPassword').val(userPassword);
            $('.login-form button[type="submit"]').trigger("click");

        }).fail(function () {
			$('#modal-uploading').modal('hide');
            alert("User already existed. Please try new username or email instead...")
            console.log("Failed to add new user!")
        });
    });
});
