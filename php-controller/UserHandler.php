<?php

/**
 * Created by IntelliJ IDEA.
 * User: VINH
 * Date: 3/18/2016
 * Time: 11:15 AM
 */
class UserHandler
{

    private $conn;

    public function __construct($dbConn)
    {
        $this->conn = $dbConn;
    }

    public function getAllMembers($data)
    {
        $stmt = $this->conn->prepare("SELECT MemberID, Name, BirthDate, Address, BirthPlace, Gender, Father, Avatar, Alive FROM `member` WHERE UserID = ".$data);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        echo json_encode($stmt->fetchAll());
    }

    public function insertMember($data)
    {
        $userID = $data['UserID'];
        $father = $data['Father'];
		if ($father == 0)
			$sql = "INSERT INTO `member` (`UserID`, `MemberID`, `Name`, `BirthDate`, `Address`, `BirthPlace`, `Gender`, `Father`, `Level` ,`Alive`, `Avatar`) VALUES (".$userID.", NULL, '".$data['Name']."', '".$data['BirthDate']."', '".$data['Address']."', '".$data['BirthPlace']."', '".$data['Gender']."',NULL, '0' , '".$data['Status']."','" .$data['Avatar']."')";
		else
			$sql = "INSERT INTO `member` (`UserID`, `MemberID`, `Name`, `BirthDate`, `Address`, `BirthPlace`, `Gender`, `Father`, `Level` ,`Alive`, `Avatar`) VALUES (".$userID.", NULL, '".$data['Name']."', '".$data['BirthDate']."', '".$data['Address']."', '".$data['BirthPlace']."', '".$data['Gender']."',". $father .", '0' , '".$data['Status']."','" .$data['Avatar']."')";

        // use exec() because no results are returned
        $this->conn->exec($sql);

        // return new inserted member as JSON
        $this->getMember($userID,$this->conn->lastInsertId());
    }

    public function deleteMember($data)
    {
        $sql = "DELETE FROM `member` WHERE `UserID`= ".$data['UserID']." AND `MemberID`=". $data['MemberID'];
        $this->conn->exec($sql);
        echo "Success";
    }

    public function updateMember($data)
    {
        $sql = "UPDATE `member` SET `Name`='". $data['Name'] ."',`BirthDate`='". $data['BirthDate'] ."',`Address`='". $data['Address'] ."',`BirthPlace`='". $data['BirthPlace'] ."',`Gender`='". $data['Gender'] ."',`Alive`='". $data['Status']."',`Avatar`='". $data['Avatar'] ."' WHERE `userID`=". $data['UserID'] ." AND `MemberID`=".$data['MemberID'];

        // use exec() because no results are returned
        $this->conn->exec($sql);

        // return new inserted member as JSON
        $this->getMember($data['UserID'],$data['MemberID']);
    }

    public function uploadAvatar($data)
    {
        $sql = "UPDATE `member` SET `Avatar`='". $data['Avatar'] ."' WHERE `userID`=". $data['UserID'] ." AND `MemberID`=".$data['MemberID'];
        $this->conn->exec($sql);
        $this->getMember($data['UserID'],$data['MemberID']);
    }

    public function getMember($userID, $memberID)
    {
        // return last inserted member ID
        $sql = "SELECT * FROM `member` WHERE `MemberID`= ". $memberID ." AND UserID = ".$userID;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        echo json_encode($result);
    }
}
