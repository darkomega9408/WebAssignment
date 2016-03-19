<?php
<<<<<<< ceb68c82e8e815e54d3aa239fd397bc9c88b4ff6

require_once 'UserHandler.php';

$userHandler = new UserHandler();
$userHandler->connectDB();

// Classify actions client requested server
if( isset($_GET['operation']) ){

    if( $_GET['operation'] == "add" )
        $userHandler->insertMember($_GET['sentData']);
    else if ( $_GET['operation'] == "delete" )
        $userHandler->deleteMember($_GET['sentData']);
    else if ( $_GET['operation'] == "update" )
        $userHandler->updateMember($_GET['sentData']);
}
else
    $userHandler->getAllMembers($_GET['UserID']);

$userHandler->closeDB();


?>
