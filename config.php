<?php

class DB{
    public static $hostName = "localhost";      //your mysql host name
    public static $userName = "root";			//your mysql user name
    public static $password = "";			    //your mysql password
    public static $dbName = "webassignment";	//your mysql database
}

class ImgurAPIKey{
    public static $clientID = "ae6e3c4095f9247";
    public static $clientSecret = "211f083a09236f3806bdcebce319f69f691af1d4";
}

class Token{
  public static $jwt_key = 'secret_server_key';
}


//$db = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_database", $mysql_user, $mysql_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
