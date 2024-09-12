<?php

class Database{
    private $host = 'localhost',
    $dbName = 'oophp-todolist',
    $username = 'root',
    $password = '';
    private PDO $conn;

    public function __construct()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbName}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getConnection(): PDO{
        return $this->conn;
    }
}