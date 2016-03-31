$(document).ready(function(){
    if (getCookie("giaphaauth") != "")
        document.location.href = "tree.php";

    $("#formLogin").submit(function(event) {
        event.preventDefault();

        var username = $("#inputUsername").val();
        var password = $("#inputPassword").val();
        var authstring = btoa(username + ":" + password);

        $.ajax({
            type: "POST",
            url: "http://localhost:8080/hello-restful/webservice/giapha/checkuser",
            beforeSend: function(request) {
                request.setRequestHeader("Authorization", "Basic " + authstring);
            }
        }).done(function(data) {

            if (data.length != 0) {
                console.log(data);
                setCookie("giaphaauth", authstring, 1);
                if( data.role == "admin" )
                    document.location.href = "admin-page.php";
                else document.location.href = "tree.php";
            }
            else
                alert("failed");
        }).error(function(err) {
            console.log(err);
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
            username:userName,
            password: userPassword,
            name: name,
            email: userEmail,
            role: "user" // default role
        };
        console.log(sentData);
        $.ajax({
            url: 'http://localhost:8080/hello-restful/webservice/giapha/addmember',
            type: 'POST',
            contentType: "application/json",
            data: JSON.stringify({
                operation: "add",
                role : "admin",
                sentData: sentData
            }),
            dataType: 'json',
            beforeSend: function(request) {
                // Special power => don't need to authenticate
                var authstring = btoa("admin:admin");
                request.setRequestHeader("Authorization", "Basic " + authstring);
            }
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

