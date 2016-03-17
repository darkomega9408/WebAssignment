<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=webassignment", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT MemberID, Name, BirthDate, Address, BirthPlace, Gender, Father, Level FROM `member` WHERE Username = 'tam'");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    echo json_encode($stmt->fetchAll());
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


?>