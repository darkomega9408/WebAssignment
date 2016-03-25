<?php

/**
 * Created by IntelliJ IDEA.
 * User: VINH
 * Date: 3/24/2016
 * Time: 6:36 PM
 */
require_once 'Paginate.php';

class AdminHandler
{
    private $conn;
    private $per_page = 5;

    public function __construct($dbConn)
    {
        $this->conn = $dbConn;
    }

    public function getAllUsers(){
        $per_page = $this->per_page;         // number of results to show per page
        $stmt = $this->conn->prepare("SELECT * FROM `person` WHERE `Role` = 'user'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        $total_results = $stmt->rowCount();
        $total_pages = ceil($total_results / $per_page);//total pages we going to have
        $shown_page = 0;

        //-------------if page is setcheck------------------//
        if (isset($_GET['page'])) {
            $show_page = $_GET['page'];             //it will telles the current page

            if ($show_page > 0 && $show_page <= $total_pages) {
                $start = ($show_page - 1) * $per_page;
                $end = $start + $per_page;
            } else {
                // error - show first set of results
                $start = 0;
                $end = $per_page;
            }

            // display pagination
            $shown_page = intval($_GET['page']);
        } else {
            // if page isn't set, show first set of results
            $start = 0;
            $end = $per_page;
        }

        $tpages = $total_pages;
        if ($shown_page <= 0)
            $shown_page = 1;

        $out = array("tbody" => "" , "pagination"=> "");
        $reload = $_SERVER['PHP_SELF'] . "?tpages=" . $tpages;

        // loop through results of database query, displaying them in the table
        for ($i = $start; $i < $end; $i++) {
            // make sure that PHP doesn't try to show results that don't exist
            if ($i == $total_results) {
                break;
            }

            // echo out the contents of each row into a table
            $out["tbody"].= '<tr id="user'.$result[$i]['ID'].'">';
            $out["tbody"].= '<td><input type=\'checkbox\' class=\'checkthis\' /></td>';
            $out["tbody"].= '<td>' . $result[$i]['ID']. '</td>';
            $out["tbody"].= '<td>' . $result[$i]['Username']. '</td>';
            $out["tbody"].= '<td>' . $result[$i]['Email']. '</td>';
            $out["tbody"].= '<td>' . $result[$i]['Name']. '</td>';
            $out["tbody"].= '<td><p data-placement="top" data-toggle="tooltip" title="Edit">'.
                '<button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit"><span class="glyphicon glyphicon-pencil"></span></button></p></td>';
            $out["tbody"].= '<td><p data-placement="top" data-toggle="tooltip" title="Delete">'.
                '<button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete"><span class="glyphicon glyphicon-trash"></span></button></p></td>';
            $out["tbody"].= "</tr>";
        }
        // ~~

        // Pagination
        $out["pagination"].= '<ul class="pagination pull-right" style="text-align:center">';
        if ($total_pages > 1)
            $out["pagination"].= paginate($reload, $shown_page, $total_pages);
        $out["pagination"].= "</ul>";

        echo json_encode($out,JSON_PRETTY_PRINT);
    }

    public function insertUser($data){
        $sql = "INSERT INTO `person` (`Username`, `Email`, `Name`, `Role`) VALUES ('".$data['UserName']."', '".$data['Email']."', '".$data['Name']."', 'user')";

        // use exec() because no results are returned
        $this->conn->exec($sql);

        // return new inserted member as JSON
        $this->getUser($this->conn->lastInsertId());
    }

    public function deleteUser($data)
    {
        $sql = "DELETE FROM `person` WHERE `ID`= ".$data['ID'];
        $this->conn->exec($sql);
        echo "Success";
    }

    public function updateUser($data){
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