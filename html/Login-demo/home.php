<?php
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require("vendor/firebase/php-jwt/src/JWT.php");
use Firebase\JWT\JWT;

if (!isset($_COOKIE["token"])) header("Location: index.html");
else {
  $token = $_COOKIE["token"];
  $decoded_data = (array) JWT::decode($token, Token::$jwt_key, ['alg' => 'HS512']);
  $id = $decoded_data["userID"];
  $conn = new PDO("mysql:host=localhost;dbname=webassignment", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  $name = $conn->query("SELECT Name FROM `person` WHERE ID='$id'")->fetchColumn();
}
?>
<!DOCTYPE html>

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
    <?php echo "Hello " . $name; ?>
    <br>
    <button>Sign out</button>
  </body>
</html>
