<?php

require_once 'DBConnection.php';
require_once 'UserHandler.php';
require_once 'AdminHandler.php';

$dbConn = new DBConnection();

if( isset($_GET['role']) )
{

    // Call UserHandler
    if( $_GET['role'] == 'user' ){
        $userHandler = new UserHandler($dbConn->conn);

        // Classify actions client requested server
        if( isset($_GET['operation']) ){
            if ( $_GET['operation'] == "delete" )
                $userHandler->deleteMember($_GET['sentData']);
            else if ( $_GET['operation'] == "changeAvatar")
                $userHandler->uploadAvatar($_GET['sentData']);
        }
        else $userHandler->getAllMembers($_GET['UserID']);

    }
    // End UserHandler


    // Call AdminHandler
    else if ( $_GET['role'] == 'admin' ){
        $adminHandler = new AdminHandler($dbConn->conn);

        // Classify actions client requested server
        if( isset($_GET['operation']) ){
            if ( $_GET['operation'] == "delete" )
                $adminHandler->deleteUser($_GET['sentData']);
        }
        else $adminHandler->getAllUsers(/*$_GET['AdminID']*/);
    }
    // End AdminHandler

}
// POST 
else if ( isset($_POST['role']) ) {

    // Call UserHandler
    if( $_POST['role'] == 'user' ){
        $userHandler = new UserHandler($dbConn->conn);

        // Classify actions client requested server
        if( isset($_POST['operation']) ){
            if( $_POST['operation'] == "add" )
                $userHandler->insertMember($_POST['sentData']);
            else if ( $_POST['operation'] == "update" )
                $userHandler->updateMember($_POST['sentData']);
        }
    }
    // End UserHandler


    // Call AdminHandler
    else if ( $_POST['role'] == 'admin' ){
        $adminHandler = new AdminHandler($dbConn->conn);

        // Classify actions client requested server
        if( isset($_POST['operation']) ){
            if( $_POST['operation'] == "add" )
                $adminHandler->insertUser($_POST['sentData']);
            else if ( $_POST['operation'] == "update" )
                $adminHandler->updateUser($_POST['sentData']);
        }
    }
    // End AdminHandler
}
else echo "NO ROLE FOUND";


// Call Destructor from DBconnection by this way
$dbConn = null;

?>
