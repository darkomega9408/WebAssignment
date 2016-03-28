$(document).ready(function(){
    $("#formLogin").submit(function(event) {
        event.preventDefault();
        var username = $("#inputUsername").val();
        var password = $("#inputPassword").val();
        $.ajax({
            type: "POST",
            url: "http://localhost:8080/hello-restful/webservice/giapha/checkuser",
            beforeSend: function(request) {
                request.setRequestHeader("Authorization", "Basic " + btoa(username + ":" + password));
            }
        }).done(function(data) {
            if (data == "Login user successfully") {
                document.location.href = "tree.php";
            }
        }).error(function(err) {
            console.log(err);
        });
    });
});