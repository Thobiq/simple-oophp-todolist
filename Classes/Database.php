<?php

require __DIR__.'/../config/config.php';

class Database{
    private $host = DB_HOST,
    $dbName = DB_NAME,
    $username = DB_USER,
    $password = DB_PASS;
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