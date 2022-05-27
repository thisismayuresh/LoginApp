<?php
 /**
 * @description: User class create a new user.
 */
require_once("Database.php");

class User {
   private $first_name;
   private $last_name;
   private $email;
   private $password;
   private $confirm_password;
   private $error;

  /** Assign the data to properties */
  public function __construct($user) {
    $this->first_name = $user['first_name'];
    $this->last_name = $user['last_name'];
    $this->email = $user['email'];
    $this->password = $user['password'];
    $this->confirm_password = $user['conf_password'];
    $this->terms = $user['terms'];
    $this->error = null;
  }
  
  /** Validate user entered data */
  public function validate(){
    /** Validate Name */
    if (!$this->first_name || !$this->last_name) {
      $this->error .= "<li>First and Last name are mandatory.</li>";
    }
    /** Validate Email */
    if(!$this->email) {
      $this->error .= "<li>Email cannot be left blank.</li>";
    } elseif (!strpos($this->email, '@') || !strpos($this->email, '.')) {
      $this->error .= "<li>Enter a valid email.</li>";   
    } else { 
      $db = new database();
      if($db->checkUniquEmail($this->email)) {
        $this->error .= "<li>Email already exists!. Try another.</li>";   
      }
    }
    /** Validate Password */
    if (!$this->password || !$this->confirm_password) {
      $this->error .= "<li>Password and Conform Password are Required.</li>";
    } elseif(strlen($this->password) <6){
      $this->error .= "<li>Password must be atleast 6 characters long.</li>";
    } elseif($this->password !== $this->confirm_password) {
      $this->error .= "<li>Password and confirm password do not match</li>";
    } 
    /** Validate Terms */
    if (!$this->terms) {
      $this->error .= "<li>Please accept terms and conditions</li>";
    }
    return $this->error;
  }
  public function getFirstName() {
    return $this->first_name; 
  }
  public function getLastName() {
    return $this->last_name;
  }
  public function getEmail() {
    return $this->email; 
  }
  public function getPassword() {
    return $this->password;
  }
  //insert into database a new user
  public function insert() { 
    $db = new database();
    
    return $db->insert($this);
  }
}