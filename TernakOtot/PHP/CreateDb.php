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
            $sql = " CREATE TABLE IF NOT EXISTS $tablename
                            (id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                             gym_name VARCHAR (25) NOT NULL,
                             gym_price FLOAT,
                             gym_image VARCHAR (100),
                             gym_star INT,
                             gym_cat VARCHAR(20)
                            );";

            if (!mysqli_query($this->con, $sql)){
                echo "Error creating table : " . mysqli_error($this->con);
            }
        }
        else{
            return false;
        }
    }
    public function getData(){
        $sql = "SELECT * FROM $this->tablename";

        $result = mysqli_query($this->con, $sql);

        if(mysqli_num_rows($result) > 0){
            return $result;
        }
    }

    public function getDataById($id){
        $sql = "SELECT * FROM $this->tablename WHERE id = '$id'";
        $result = $this->con->query($sql);
        return $result;
    }
    
    public function searchData($keyword){
        $sql = "SELECT * FROM gymtb WHERE gym_name LIKE '%$keyword%' OR gym_cat LIKE '%$keyword%' OR gym_star LIKE '%$keyword%' OR gym_price LIKE '%$keyword%' OR gym_cat LIKE '%$keyword%'";
        $result = $this->con->query($sql);
        return $result;
    }
    public function UpDataById($id, $m, $q, $t){
        $sql = "UPDATE $this->tablename SET month='$m',qty='$q', total='$t'  WHERE id = '$id'";
        $result = $this->con->query($sql);
        return $result;
    }
    public function UpDataId($id, $t){
        $sql = "UPDATE $this->tablename SET month='1',qty='1', total='$t'  WHERE id = '$id'";
        $result = $this->con->query($sql);
        return $result;
    }

}


?>



