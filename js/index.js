$(document).ready(function(){
    var lang = $("head").data("lang");

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
                    document.location.href = 'tree';
                else document.location.href = 'management';
                console.log(document.location.href);
            }
            else if (res.status == 'user_not_found') {
                $('#warning').html('<i class="fa fa-fw fa-exclamation-circle fa-2x"></i><span>'+
                    msg[lang]["user_or_pass_incorrect"]+'</span>');
            }
        }).fail(function(err) {
            $('#modal-uploading').modal('hide');
            console.log(err);
        });
    });



    $("#modal-sign-up-btn").click(function (e) {
        
        var userName = $("#signUp .userName").val();
        var userID = $("#signUp .userID").val();
        var userPassword = $("#signUp .userPassword").val();
        var userRePassword = $("#signUp .userRePassword").val();
        var userEmail = $("#signUp .userEmail").val();

        // Validate step here
        if ( !validateModal(lang,'warning',userName,userPassword,userRePassword,userEmail) )
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
        }).done(function () {
			$('#modal-uploading').modal('hide');
            $("#signUp").modal('hide');

            // Auto login
            $('#inputUsername').val(userName);
            $('#inputPassword').val(userPassword);
            $('.login-form button[type="submit"]').trigger("click");

        }).fail(function () {
			$('#modal-uploading').modal('hide');
            $('#warning').html('<i class="fa fa-fw fa-exclamation-circle fa-2x"></i><span>'+
                msg[lang]["user_already_exist"]+'</span>');
            console.log("Failed to add new user!")
        });
    });
});
