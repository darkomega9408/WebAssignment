<?php
  require("../vendor/firebase/php-jwt/src/JWT.php");
  use Firebase\JWT\JWT;

  $username = $_POST["username"];
  $password = $_POST["password"];
  $conn = new PDO("mysql:host=localhost;dbname=webassignment", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  $res = $conn->query("SELECT ID FROM `person` WHERE Username = '$username' AND Password = '$password'");
  if (!$res) echo json_encode(array('status' => 'user_not_found'));
  else {
    $data = ['userID' => $res->fetchColumn()];
    $jwt = JWT::encode($data, 'secret_server_key', 'HS512');
    echo json_encode(array('status' => 'login_success', 'token' => $jwt));
  }
?>
