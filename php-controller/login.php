<?php
  require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
  require("../lib/vendor/firebase/php-jwt/src/JWT.php");
  use Firebase\JWT\JWT;

  $username = $_POST["username"];
  $password = $_POST["password"];
  $conn = new PDO("mysql:host=localhost;dbname=webassignment", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  try {
    $numRows = $conn->query("SELECT COUNT(*) FROM `person` WHERE Username = '$username' AND Password = '$password'")->fetchColumn();
    if ($numRows == 0) echo json_encode(array('status' => 'user_not_found'));
    else {
      $res = $conn->query("SELECT ID, Role FROM `person` WHERE Username = '$username' AND Password = '$password'")->fetch(PDO::FETCH_ASSOC);

      $data = [
        'iss'  => 'localhost',
        'data' => [
            'id'   => $res['ID'],
            'role' => $res['Role']
        ]
      ];
      $token = JWT::encode($data, Token::$jwt_key, 'HS512');
      echo json_encode(array('status' => 'login_success', 'token' => $token, 'role' => $res['Role']));
    }
  } catch (Exception $e) {
    echo $e->getMessage();
  }
?>
