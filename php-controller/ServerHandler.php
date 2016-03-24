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

    }
    // End AdminHandler

}else echo "No role found";


// Call Destructor from DBconnection by this way
$dbConn = null;

?>
