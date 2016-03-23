$(document).ready(function() {
  $(".login-form").submit(function(e) {
    e.preventDefault();
    var username = $("#username").val();
    var password = $("#password").val();
    var args = {username: username, password: password};
    $.post("server/user.php", args, function(res) {
      var data = JSON.parse(res);
      if (data.status == "login_success") {
        document.cookie = "token=" + data.token + "; expires=" + String(new Date().getTime() + (86400 * 30));
        window.location = "home.php";
      }
      else if (data.status == "user_not_found") {
        alert("Username or password is incorrect");
      }
    }).fail(function(err) {
      alert("Internal Server Error");
    });
  })
})
