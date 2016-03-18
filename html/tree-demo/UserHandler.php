<?php

/**
 * Created by IntelliJ IDEA.
 * User: VINH
 * Date: 3/18/2016
 * Time: 11:15 AM
 */
class UserHandler
{
    public $servername = "localhost";
    public $username = "root";
    public $password = "";
    public $dbname = "webassignment";
    public $conn;

    public function connectDB(){
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }
        return true;
    }

    public function closeDB()
    {
        $this->conn = null;
    }

    public function getAllMembers()
    {
        $stmt = $this->conn->prepare("SELECT MemberID, Name, BirthDate, Address, BirthPlace, Gender, Father, Level FROM `member` WHERE Username = 'tam'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        echo json_encode($stmt->fetchAll());
    }

    public function insertMember($data)
    {
        $father = $data['Father'];
        $sql = "INSERT INTO `member` (`Username`, `MemberID`, `Name`, `BirthDate`, `Address`, `BirthPlace`, `Gender`, `Father`, `Level`) VALUES ('tam', NULL, 'tâm gay chúa', '2016-03-09', 'bình hưng hòa', 'sao hỏa', 'male',". $father .", '0')";

        // use exec() because no results are returned
        $this->conn->exec($sql);

        //$this->getAllMembers();
        //echo $this->conn->lastInsertId()."<br>";
        $sql = "SELECT * FROM `member` WHERE `MemberID`= ". $this->conn->lastInsertId() ." AND Username = 'tam'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        echo json_encode($result);
    }

    public function deleteMember($data)
    {
        $sql = "DELETE FROM `member` WHERE `Username`='tam' AND `MemberID`=". $data;
        $this->conn->exec($sql);
        echo "Success";
    }

    public function updateMember($data)
    {

    }
}