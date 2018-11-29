<?php

//creating singleton class
class Database {
 
    private static $instance = null; 
    private $conn;

    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "api_db";
    private $username = "root";
    private $password = "";
 
    // get the database connection
    private function __construct() {
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            // echo("connected Successfully");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }

    public static function getInstance()
    {
        if (self::$instance == null)
        {
          self::$instance = new Database();
        }
     
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function __clone()
    {
        trigger_error('Cloning forbidden.', E_USER_ERROR);
    }
}

?>
