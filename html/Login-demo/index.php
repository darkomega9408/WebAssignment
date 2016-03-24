<?php
$token = "";
if (isset($_COOKIE["token"])) header("Location: home.php");
?>
<!DOCTYPE html>

<html>
  <head>
    <title>Login Demo</title>
    <meta charset="utf-8">
    <script src="js/jquery-2.2.1.min.js"></script>
    <script src="js/index.js"></script>
  </head>
  <body>
    <form class="login-form">
      Username
      <input type="text" id="username" name="username" required>
      <br>
      Password
      <input type="password" id="password" name="password" required>
      <br>
      <input type="submit" value="Sign in">
    </form>
  </body>
</html>
