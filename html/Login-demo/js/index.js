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
    }).fail(function(err) {
      alert("Internal Server Error");
    });
  })
})

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
