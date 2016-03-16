

<?php
/**
 * Created by IntelliJ IDEA.
 * User: VINH
 * Date: 3/16/2016
 * Time: 10:28 AM
 */

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_assignment";


// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully\n";

//select a database to work with
$selected = mysqli_select_db($conn,$dbname)
or die("Could not select DB\n");
//echo "Select web_assignment DB\n<br>";

// select data
$sql = "SELECT * FROM member ORDER BY `Level`ASC";
$result = mysqli_query($conn, $sql);


// Create tree

while ($row = mysqli_fetch_assoc($result)){
    /*echo "<ul>
            <li>
                <div id='_".$row{'MemberID'}."'></div>
                <ul></ul>
             </li>
         </ul>";*/
//    echo "ID: ".$row{'MemberID'}."\nFatherID: ".$row{'FatherID'}."\nLevel: ".$row{'Level'}."<br>";
    $data[] = array(
        'MemberID' => $row{'MemberID'},
        'FatherID' => $row{'FatherID'},
        'Level' => $row{'Level'}
    );

}

echo json_encode($data);

// Insert data
/*$sql = "INSERT INTO cars (NAME ,YEAR )
VALUES ('ABC', '2007')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}*/


mysqli_close($conn);









