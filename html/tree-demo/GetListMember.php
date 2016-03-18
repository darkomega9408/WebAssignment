<?php

require_once 'UserHandler.php';

$userHandler = new UserHandler();
$userHandler->connectDB();

if( isset($_GET['operation']) && $_GET['operation'] == "add" ){
    $userHandler->insertMember($_GET['sentData']);
//    echo $_GET['sentData']['Username'];
}
else if ( isset($_GET['operation']) && $_GET['operation'] == "delete" )
    $userHandler->deleteMember($_GET['sentData']);

$userHandler->getAllMembers();

$userHandler->closeDB();


?>