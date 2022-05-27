<?php 
//use PDO;
require_once("User.php");
class Database
{
    private $host;
    private $user;
    private $password;
    private $database;
    private $dbconn;
    
    function __construct()
    {
        $this->host = 'localhost';
        $this->user = 'root';
        $this->password = '';
        $this->database = 'dbuser';
        $this->dbconn = null;
    }
   /** Connect to database */
    public function connect()
    {
        try {
            $this->dbconn = new PDO('mysql:host='.$this->host.';dbname='.$this->database.'', $this->user, $this->password) or
            die("Cannot connect to XAMPP MySQL.");
            // set the PDO error mode to exception
            $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->dbconn;
        } catch(PDOException $e) {
            echo "Database connection failed: " . $e->getMessage();
            die();
        }
    }

    
    /** Insert user data into database */
    public function insert($data) {
        $this->dbconn = $this->connect();
        $password = sha1($data->getPassword());
        $stmt = $this->dbconn->prepare("INSERT INTO dbuser(first_name, last_name, email, password) 
            VALUES (:first_name, :last_name, :email, :password)");
        
        $fn=$data->getFirstName();
        $ln=$data->getLastName();
        $mail=$data->getEmail();

        $stmt->bindParam(':first_name',$fn );
        $stmt->bindParam(':last_name',$ln );
        $stmt->bindParam(':email',$mail);
        $stmt->bindParam(':password', $password);
        
        // insert a row
        if($stmt->execute()){
            $result =1;
        }   
        $this->dbconn = null;
        return true;
    }
        /** chek if email is unique or not */
    public function checkUniquEmail($email) {
       
        $this->dbconn = $this->connect();
        $query = $this->dbconn->prepare( "SELECT `email` FROM `dbuser` WHERE `email` = :email" );
        $query->bindValue(':email', $email );
        $query->execute();
        if($query->rowCount() > 0) { # If rows are found for query
            return true;
        } else {
            return false;
        }
        $this->dbconn = null;
    }
}