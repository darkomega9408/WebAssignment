<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
try {
    $conn = new PDO("mysql:host=".DB::$hostName.";dbname=".DB::$dbName, DB::$userName, DB::$password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    return false;
}

$stmt = $conn->prepare("SELECT * FROM `person` WHERE `Role` = 'user'");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
echo json_encode($stmt->fetchAll());
?>
