$(document).ready(function(){

	function checkUser(authstring) {
		        $.ajax({
            type: "POST",
            url: "https://tamrestfultest.herokuapp.com/webservice/giapha/checkuser",
            beforeSend: function(request) {
				$('#modal-uploading').modal('show');
                request.setRequestHeader("Authorization", "Basic " + authstring);
            }
        }).done(function(data) {
			$('#modal-uploading').modal('hide');
            if (data.length != 0) {
                console.log(data);
                setCookie("giaphaauth", authstring, 1);
                if( data.role == "admin" )
                    document.location.href = "../admin-page.html";
                else document.location.href = "../tree.html";
            }
            else
                alert("failed");
        }).error(function(err) {
			$('#modal-uploading').modal('hide');
            console.log(err);
        });
	}

	if (getCookie("giaphaauth") != '') {
		checkUser(getCookie("giaphaauth"));
	}

    $("#formLogin").submit(function(event) {
        event.preventDefault();

        var username = $("#inputUsername").val();
        var password = $("#inputPassword").val();
        var authstring = btoa(username + ":" + password);

        checkUser(authstring);
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
            url: 'https://tamrestfultest.herokuapp.com/webservice/giapha/addmember',
            type: 'POST',
            contentType: "application/json",
            data: JSON.stringify({
                operation: "add",
                role : "admin",
                sentData: sentData
            }),
            dataType: 'json',
            beforeSend: function(request) {
				$('#modal-uploading').modal('show');
                // Special power => don't need to authenticate
                var authstring = btoa("admin:admin");
                request.setRequestHeader("Authorization", "Basic " + authstring);
            }
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
            console.log("Failed to add new user!")
        });
    });
});

