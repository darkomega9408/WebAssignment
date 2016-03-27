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
        alert('You have logged in succesfully');
        setCookie('token', res.token, 30);
        if (res.role == 'user') window.location = 'tree.php';
        else window.location = 'admin-page.php';
      }
    }).fail(function(err) {
      alert(err + " error");
    });
  })
})
