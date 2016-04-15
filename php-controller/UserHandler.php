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
        $stmt = $this->conn->prepare("SELECT MemberID, Name, BirthDate, Address, BirthPlace, Gender, Father, Alive FROM `member` WHERE UserID = $data");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        echo json_encode($stmt->fetchAll());
    }

    public function insertMember($data)
    {
        $userID = $data['UserID'];
        $father = $data['Father'];
		if ($father == 0)
			$sql = "INSERT INTO `member` (`UserID`, `MemberID`, `Name`, `BirthDate`, `Address`, `BirthPlace`, `Gender`, `Father` ,`Alive`) VALUES (".$userID.", NULL, '".$data['Name']."', '".$data['BirthDate']."', '".$data['Address']."', '".$data['BirthPlace']."', '".$data['Gender']."',NULL, '".$data['Alive'] ."')";
		else
			$sql = "INSERT INTO `member` (`UserID`, `MemberID`, `Name`, `BirthDate`, `Address`, `BirthPlace`, `Gender`, `Father` ,`Alive`) VALUES (".$userID.", NULL, '".$data['Name']."', '".$data['BirthDate']."', '".$data['Address']."', '".$data['BirthPlace']."', '".$data['Gender']."',". $father .", '".$data['Alive'] ."')";

        // use exec() because no results are returned
        //$this->conn->exec($sql);
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute()) {
            $sql = "SELECT MemberID FROM member ORDER BY MemberID DESC LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $memberID = $stmt->fetchAll()[0][0];

            $xml = new DOMDocument();
            $xml_avatars = $xml->createElement("avatars");
            $xml_initAvatar = $xml->createElement("avatar");
            $xml_initAvatar->nodeValue = $data['Avatar'];
            $xml_avatars->appendChild($xml_initAvatar);
            for ($i = 1; $i <= 4; $i++) {
                $xml_avatar = $xml->createElement("avatar");
                $xml_avatar->nodeValue = "empty";
                $xml_avatars->appendChild($xml_avatar);
            }
            $xml->appendChild($xml_avatars);
            $xml->save('../member_avatar/' . $memberID . '.xml');
        }

        // return new inserted member as JSON
        $this->getMember($userID,$this->conn->lastInsertId());

    }

    public function deleteMember($data)
    {
        $sql = "DELETE FROM `member` WHERE `UserID`= ".$data['UserID']." AND `MemberID`=". $data['MemberID'];
        $this->conn->exec($sql);
        unlink('../member_avatar/' . $data['MemberID'] . '.xml');
        echo "Success";
    }

    public function updateMember($data)
    {
        $sql = "UPDATE `member` SET `Name`='". $data['Name'] ."',`BirthDate`='". $data['BirthDate'] ."',`Address`='". $data['Address'] ."',`BirthPlace`='". $data['BirthPlace'] ."',`Gender`='". $data['Gender'] ."',`Alive`='". $data['Alive']. "' WHERE `userID`=". $data['UserID'] ." AND `MemberID`=".$data['MemberID'];

        // use exec() because no results are returned
        $this->conn->exec($sql);

        // return new inserted member as JSON
        $this->getMember($data['UserID'],$data['MemberID']);
    }

    public function uploadAvatar($data)
    {
        $sql = "UPDATE `member` SET `Avatar`='". $data['Avatar'] ."' WHERE `userID`=". $data['UserID'] ." AND `MemberID`=".$data['MemberID'];
        $this->conn->exec($sql);

        $memberID = $data["MemberID"];
        $xml = new DOMDocument();
        $xml->load('../member_avatar/' . $memberID . '.xml');
        $xml->getElementsByTagName("avatar")[$data["AvatarID"]]->nodeValue=$data['Avatar'];
        $xml->save('../member_avatar/' . $memberID . '.xml');

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

    public function loadAvatar($data)
    {
        $memberID = $data["MemberID"];
        $xml = new DOMDocument();
        $xml->load('../member_avatar/' . $memberID . '.xml');
        echo $xml->saveXML();
    }
}
