
<?php
    
class DB {
    protected $host = 'localhost';
    protected $server = 'root';
    protected $password = '';
    protected $dbname = 'inventory';

    public static $sharedConnection = null;

    protected function connect() {
        if (self::$sharedConnection === null) {
            self::$sharedConnection = new mysqli($this->host, $this->server, $this->password, $this->dbname);
            if (self::$sharedConnection->connect_error) {
                die("Connection failed: " . self::$sharedConnection->connect_error);
            }
        }
        return self::$sharedConnection;
    }

    protected function closeConnection() {
        if (self::$sharedConnection !== null) {
            self::$sharedConnection->close();
            self::$sharedConnection = null;
        }
    }
}
