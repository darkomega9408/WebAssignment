<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=webassignment", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT MemberID, Name, BirthDate, Address, BirthPlace, Gender, Father, Level, Avatar FROM `member` WHERE userID = 2");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    echo json_encode($stmt->fetchAll());
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


?>