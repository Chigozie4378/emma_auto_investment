
<?php
class DB{
    protected $host = 'localhost';
    protected $server = 'root';
    protected $password = '';
    protected $dbname = 'inventory';

    public function connect(){
        $conn = mysqli_connect($this->host,$this->server,$this->password,$this->dbname);
        if ($conn->connect_error){
            echo "Failed".$conn->connect_error;
        }
        return $conn;
    }

}
?>