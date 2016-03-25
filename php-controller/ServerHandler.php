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
            if( $_GET['operation'] == "add" )
                $userHandler->insertMember($_GET['sentData']);
            else if ( $_GET['operation'] == "delete" )
                $userHandler->deleteMember($_GET['sentData']);
            else if ( $_GET['operation'] == "update" )
                $userHandler->updateMember($_GET['sentData']);
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

}else {
    $adminHandler = new AdminHandler($dbConn->conn);
    echo "no role";
    // Classify actions client requested server
    if( isset($_GET['operation']) ){
        /*if( $_GET['operation'] == "add" )
            $adminHandler->insertMember($_GET['sentData']);
        else if ( $_GET['operation'] == "delete" )
            $adminHandler->deleteMember($_GET['sentData']);
        else if ( $_GET['operation'] == "update" )
            $adminHandler->updateMember($_GET['sentData']);*/
    }
    else $adminHandler->getAllUsers(/*$_GET['AdminID']*/);
}
    //echo "No role found";


// Call Destructor from DBconnection by this way
$dbConn = null;

?>
