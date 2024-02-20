<?php
class CreateDb{
    public $servername;
    public $username;
    public $password;
    public $dbname;
    public $tablename;
    public $con;
    // class constructor
    public function __construct(
        $dbname = "Newdb",
        $tablename = "Gymdb",
        $servername = "localhost",
        $username = "root",
        $password = ""
    )
    {
        $this->dbname = $dbname;
        $this->tablename = $tablename;
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
      // create connection
        $this->con = mysqli_connect($servername, $username, $password);
        // Check connection
        if (!$this->con){
            die("Connection failed : " . mysqli_connect_error());
        }
        // query
        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
        // execute query
        if(mysqli_query($this->con, $sql)){
            $this->con = mysqli_connect($servername, $username, $password, $dbname);
            // sql to create new table
            $sql = "CREATE TABLE IF NOT EXISTS $tablename (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(100) NOT NULL UNIQUE,
                email VARCHAR(100) NOT NULL UNIQUE,
                telepon INT,
                password VARCHAR(200),
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";            
            
            if (!mysqli_query($this->con, $sql)){
                echo "Error creating table : " . mysqli_error($this->con);
            }
        }
        else{
            return false;
        }
    }

    public function insertData($username, $email, $password) {
        $username = mysqli_real_escape_string($this->con, $username);
        $email = mysqli_real_escape_string($this->con, $email);
        $password = mysqli_real_escape_string($this->con, $password);

        $sql = "INSERT INTO $this->tablename (username, email, password)
                VALUES ('$username', '$email', '$password')";

        if (!mysqli_query($this->con, $sql)) {
            echo "Error inserting data: " . mysqli_error($this->con);
            exit;
        }
    }

    public function getData(){
        $sql = "SELECT * FROM $this->tablename";

        $result = mysqli_query($this->con, $sql);

        if(mysqli_num_rows($result) > 0){
            return $result;
        }
    }

    public function getUserByUsername($username) {
        $username = mysqli_real_escape_string($this->con, $username);
        $sql = "SELECT * FROM $this->tablename WHERE username = '$username'";
        $result = mysqli_query($this->con, $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            return null;
        }
    }
    
    public function updateUserPhone($username, $newPhone) {
        $sql = "UPDATE $this->tablename SET telepon='$newPhone' WHERE username='$username'";
        $result = mysqli_query($this->con, $sql);
        if (!$result) {
            echo "Error updating phone number: " . mysqli_error($this->con);
        }
    }

    public function updateUserPassword($username, $newPassword) {
        $sql = "UPDATE $this->tablename SET password = '$newPassword' WHERE username = '$username'";
        $result = mysqli_query($this->con, $sql);
        if (!$result) {
            echo "Error updating password: " . mysqli_error($this->con);
        }
    }
    
    
    public function getUserByEmail($email) {
        $email = mysqli_real_escape_string($this->con, $email);
        $sql = "SELECT * FROM $this->tablename WHERE email = '$email'";
        $result = mysqli_query($this->con, $sql);
        return mysqli_fetch_assoc($result);
    }

}
?>