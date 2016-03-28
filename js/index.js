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
                document.location.href = "tree.php";
            }
            else
                alert("failed");
        }).error(function(err) {
            console.log(err);
        });
    });
});