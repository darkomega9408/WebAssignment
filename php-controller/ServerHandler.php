<?php
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once 'DBConnection.php';
require_once 'UserHandler.php';
require_once 'AdminHandler.php';
require("../lib/vendor/firebase/php-jwt/src/JWT.php");
use Firebase\JWT\JWT;

$dbConn = new DBConnection();

if (!isset($_COOKIE['token'])) {
  header('HTTP/1.1 400 Bad Request');
  exit;
}

$token = $_COOKIE['token'];
$data = (array) JWT::decode($token, Token::$jwt_key, ['alg' => 'HS512']);
if (!$data) {
  header('HTTP/1.1 400 Bad Request');
  exit;
}
$personData = (array) $data['data'];
$id = $personData['id'];
$role = $personData['role'];

// Call UserHandler
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if( $role == 'user' ){
      $userHandler = new UserHandler($dbConn->conn);
	  
	  

      // Classify actions client requested server
      if( isset($_GET['operation']) ){
		  $sentData = $_GET['sentData'];
		  $sentData['UserID'] = $id;
          if( $_GET['operation'] == "add" )
              $userHandler->insertMember($sentData);
          else if ( $_GET['operation'] == "delete" )
              $userHandler->deleteMember($sentData);
          else if ( $_GET['operation'] == "update" )
              $userHandler->updateMember($sentData);
          else if ( $_GET['operation'] == "changeAvatar")
              $userHandler->uploadAvatar($sentData);
      }
      else $userHandler->getAllMembers($id);

  }
  // End UserHandler


  // Call AdminHandler
  else if ( $role == 'admin' ){
      $adminHandler = new AdminHandler($dbConn->conn);

      // Classify actions client requested server
      if( isset($_GET['operation']) ){
          if( $_GET['operation'] == "add" )
              $adminHandler->insertUser($_GET['sentData']);
          else if ( $_GET['operation'] == "delete" )
              $adminHandler->deleteUser($_GET['sentData']);
          else if ( $_GET['operation'] == "update" )
              $adminHandler->updateUser($_GET['sentData']);
      }
      else $adminHandler->getAllUsers(/*$_GET['AdminID']*/);
  }
  // End AdminHandler
  else header('HTTP/1.1 400 Bad Request');
}
else {
  header('HTTP/1.1 405 Method Not Allowed');
}
