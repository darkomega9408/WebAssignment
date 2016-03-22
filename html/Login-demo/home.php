<?php
$token = "";
if (!isset($_COOKIE["token"])) header("Location: index.php");
else $token = $_COOKIE["token"];
?>
<html>
  <head>
    <title>Login Demo</title>
    <meta charset="utf-8">
    <script src="js/jquery-2.2.1.min.js"></script>
    <script>
      $(document).ready(function() {
        $("button").click(function() {
          document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
          window.location = "index.php";
        })
      })
    </script>
  </head>
  <body>
    <?php echo $token; ?>
    <br>
    <button>Sign out</button>
  </body>
</html>
