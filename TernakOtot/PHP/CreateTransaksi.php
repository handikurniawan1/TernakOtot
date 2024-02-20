<?php
class CreateOrder{
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
            $sql = "CREATE TABLE IF NOT EXISTS $tablename
                        (id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                         username VARCHAR(100) NOT NULL,
                         barcode VARCHAR(20),
                         gym_name VARCHAR(25) NOT NULL,
                         gym_image VARCHAR(100),
                         gym_price FLOAT,
                         gym_qty FLOAT,
                         gym_month INT,
                         stat VARCHAR(20),
                         start_at DATE DEFAULT CURRENT_TIMESTAMP,
                         end_at DATE,
                         total FLOAT
                        );";

            if (!mysqli_query($this->con, $sql)){
                echo "Error creating table : " . mysqli_error($this->con);
            }
        }
        else{
            return false;
        }
        // Set default value for end_at column
        $currentDate = date("Y-m-d");
        $query = "ALTER TABLE $tablename ALTER COLUMN end_at SET DEFAULT DATE_ADD(CURRENT_DATE, INTERVAL gym_month MONTH)";
        if (!mysqli_query($this->con, $query)){
            echo "Error setting default value for end_at column : " . mysqli_error($this->con);
        }

        /*// Generate barcode value for new row
        $barcode = $this->generateBarcode();
        $nextBarcode = str_replace("-", "", $barcode); // Remove dashes for storage in database

        // Generate and update barcode value for existing rows
        $query = "SELECT id FROM $tablename";
        $result = mysqli_query($this->con, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $updateQuery = "UPDATE $tablename SET barcode = '$nextBarcode' WHERE id = " . $row['id'];
                if (!mysqli_query($this->con, $updateQuery)){
                    echo "Error updating barcode value : " . mysqli_error($this->con);
                }
            }
        }*/
    }

    // Generate barcode value
    /*private function generateBarcode(){
        $barcode = "";
        $unique = false;
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);

        while (!$unique) {
            $barcode = '';
            for ($i = 0; $i < 12; $i++) {
                $barcode .= $characters[rand(0, $charactersLength - 1)];
                if ($i % 4 === 3 && $i !== 11) {
                    $barcode .= '-';
                }
            }

            $query = "SELECT COUNT(*) AS count FROM $this->tablename WHERE barcode = '$barcode'";
            $result = mysqli_query($this->con, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if ($row['count'] == 0) {
                    $unique = true; // Barcode is unique
                }
            }
        }
        return $barcode;
    }*/

    public function getDataBykd($kd){
        $sql = "SELECT * FROM $this->tablename WHERE kd = '$kd'";
        $result = $this->con->query($sql);
        return $result;
    }
    public function searchData($keyword, $user) {
        $stmt = $this->con->prepare("SELECT * FROM history WHERE (kd LIKE ? OR stat LIKE ? OR created_at LIKE ? OR total LIKE ?) AND username = ? ORDER BY created_at DESC");
        $keyword = "%$keyword%"; // Menambahkan wildcard (%) pada keyword pencarian
        $stmt->bind_param("sssss", $keyword, $keyword, $keyword, $keyword, $user);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }
    
    public function UpDataBykd($id){
        $sql = "UPDATE $this->tablename SET stat='REQ'  WHERE id = '$id'";
        $result = $this->con->query($sql);
        return $result;
    }
    public function UpBykd($id){
        $sql = "UPDATE history SET stat='REQ'  WHERE kd = '$id'";
        $result = $this->con->query($sql);
        return $result;
    }
    
}
?>






