<?php
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once 'DBConnection.php';
require_once 'UserHandler.php';
require_once 'AdminHandler.php';
require("../lib/vendor/firebase/php-jwt/src/JWT.php");
use Firebase\JWT\JWT;

$dbConn = new DBConnection();
$token = $data = $personData = $id = $role = $sentData= "";

if (isset($_COOKIE['token'])) {
    $token = $_COOKIE['token'];
    $data = (array) JWT::decode($token, Token::$jwt_key, ['alg' => 'HS512']);
    if (!$data) {
        header('HTTP/1.1 400 Bad Request');
        exit;
    }
    $personData = (array) $data['data'];
    $id = $personData['id'];
    $role = $personData['role'];

}
else if ( isset($_POST['role']) )
    $role = $_POST['role'];
else {
    header('HTTP/1.1 400 Bad Request');
    exit;
}




// Call UserHandler
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if( isset($_GET['sentData']) )
        $sentData = $_GET['sentData'];

    if( $role == 'user' ){
        $userHandler = new UserHandler($dbConn->conn);

        // Classify actions client requested server
        if( isset($_GET['operation']) ){
            $sentData['UserID'] = $id;

            if ( $_GET['operation'] == "delete" )
                $userHandler->deleteMember($sentData);
            else if ( $_GET['operation'] == "changeAvatar")
                $userHandler->uploadAvatar($sentData);
            else if ( $_GET['operation'] == "loadAvatar")
                $userHandler->loadAvatar($sentData);
            else if( $_GET['operation'] == "getAllGuests" )
                $userHandler->getAllGuests($id);
                // Delete cascade
            else if( $_GET['operation'] == "deleteGuest" )
                $userHandler->deleteGuest($sentData);
        }
        else $userHandler->getAllMembers($id);

    }
    // End UserHandler


    // Call AdminHandler
    else if ( $role == 'admin' ){
        $adminHandler = new AdminHandler($dbConn->conn);

        // Classify actions client requested server
        if( isset($_GET['operation']) ){
            if ( $_GET['operation'] == "delete" )
                $adminHandler->deleteUser($sentData);
        }
        else $adminHandler->getAllUsers();
    }
    // End AdminHandler

    // Guest
    else if( $role == 'guest'){

        $userHandler = new UserHandler($dbConn->conn);

        // $id here is guestID => 
        $userHandler->getAllMembersForGuest($id);
    }
}
else if ( $_SERVER['REQUEST_METHOD'] = 'POST'){
    if( isset($_POST['sentData']) )
        $sentData = $_POST['sentData'];

    if( $role == 'user' || $role == null ){
        $userHandler = new UserHandler($dbConn->conn);

        // Classify actions client requested server
        if( isset($_POST['operation']) ){
            $sentData['UserID'] = $id;

            if( $_POST['operation'] == "add" )
                $userHandler->insertMember($sentData);
            else if ( $_POST['operation'] == "update" )
                $userHandler->updateMember($sentData);
            else if( $_POST['operation'] == "addGuest" )
                $userHandler->insertGuest($id,$sentData);
                // Update cascade
            else if ( $_POST['operation'] == "updateGuest" )
                $userHandler->updateGuest($sentData);
        }

    }
    // End UserHandler


    // Call AdminHandler
    else if ( $role == 'admin' ){
        $adminHandler = new AdminHandler($dbConn->conn);

        // Classify actions client requested server
        if( isset($_POST['operation']) ){
            if( $_POST['operation'] == "add" )
                $adminHandler->insertUser($sentData);
            else if ( $_POST['operation'] == "update" )
                $adminHandler->updateUser($sentData);
        }
    }
    // End AdminHandler
    else  echo "leu leu";//header('HTTP/1.1 400 Bad Request');
}
else {
    header('HTTP/1.1 405 Method Not Allowed');
}
//echo "No role found";


// Call Destructor from DBconnection by this way
$dbConn = null;

?>
