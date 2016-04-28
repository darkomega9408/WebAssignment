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

        $stmt = $this->conn->prepare($sql);
		
        if ($stmt->execute()) {
            $memberID = $this->conn->lastInsertId();

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

    public function getAllMembersForGuest($guestID)
    {
        // Use $guestID to get managedUserID first
        $res = $this->conn->query("SELECT adminID FROM `user` WHERE ID = ".$guestID)->fetch(PDO::FETCH_ASSOC);
        $managedUserID = $res['adminID'];
        if( $managedUserID == null )
            return;

        $this->getAllMembers($managedUserID);

    }
    
    public function getAllGuests($data){
        $stmt = $this->conn->prepare("SELECT * FROM `person` WHERE ID IN ( SELECT ID FROM `user` WHERE adminID = $data )");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        echo json_encode($stmt->fetchAll());
    }

    public function insertGuest($managedUserID,$data)
    {
        $sql = "INSERT INTO `person` (`Username`, `Password`, `Email`, `Name`, `Role`) VALUES ('".$data['UserName']."', '".$data['Password']."','".$data['Email']."', '".$data['Name']."', 'guest')";

        // use exec() because no results are returned
        $this->conn->exec($sql);

        $lastInsertId = $this->conn->lastInsertId();

        $sql = "INSERT INTO `user` (`ID` , `adminID`) VALUES ('".$lastInsertId."','".$managedUserID."')";
        $this->conn->exec($sql);
        
        // return new inserted member as JSON
        $this->getUser($lastInsertId);


    }

    public function deleteGuest($data)
    {
        // Delete cascade , don't need to consider `user` table anymore
        $sql = "DELETE FROM `person` WHERE `ID`= ".$data['ID'];
        $this->conn->exec($sql);
        echo "Success";
    }

    public function updateGuest($data)
    {
        // Update cascade
        $sql = "UPDATE `person` SET `Username`='". $data['UserName'] ."',`Email`='". $data['Email'] ."',`Name`='". $data['Name'] ."' WHERE `ID`=". $data['ID'] ;

        // use exec() because no results are returned
        $this->conn->exec($sql);

        // return new inserted member as JSON
        $this->getUser($data['ID']);
    }

    public function getUser($userID)
    {
        // return last inserted member ID
        $sql = "SELECT * FROM `person` WHERE `ID`= ". $userID ;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        echo json_encode($result);
    }
}
