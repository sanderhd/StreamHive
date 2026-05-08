<?php

class Database {
    private $conn;
    private $host = "localhost";
    private $dbName = "streamhive";
    private $username = "root";
    private $password = "";

    public function __construct() {
        $this->getConnection();
    }

    public function getConnection() {

        try {
            $this->conn = new PDO(
                "mysql:host=$this->host;dbname=$this->dbName",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]
            );
        } catch (PDOException $error) {
            die("Database Connection Error: " . $error->getMessage());
        }

        return $this->conn;
    }

    public function queryDatabase($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}

?>