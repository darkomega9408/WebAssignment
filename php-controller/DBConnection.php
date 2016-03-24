<?php

/**
 * Created by IntelliJ IDEA.
 * User: VINH
 * Date: 3/24/2016
 * Time: 6:15 PM
 */
require_once '../config.php';

class DBConnection
{
    public $conn;

    public function __construct(){
        try {
            $this->conn = new PDO("mysql:host=".DB::$hostName.";dbname=".DB::$dbName, DB::$userName, DB::$password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }
        return true;
    }

    public function __destruct()
    {
        $this->conn = null;
    }
}