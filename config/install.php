<?php 

require 'config.php';

try {
    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
    $conn = new PDO($dsn, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $conn->exec("USE ".DB_NAME)

    // create user table
    $sql = "CREATE TABLE IF NOT EXISTS t_users (
        id_user INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL,
        password VARCHAR(100) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    $conn->exec($sql);
    echo "Tabel user berhasil dibuat <br>";

    // create todolist status table
    $sql = "CREATE TABLE IF NOT EXISTS t_todolist_status (
        id_status INT AUTO_INCREMENT PRIMARY KEY,
        status VARCHAR(20)
    )";

    $conn->exec($sql);

    $sql = "INSERT INTO t_todolist_status (status) VALUES ('finished'), ('unfinished')";

    $conn->exec($sql);
    echo "tabel status todolist berhasil dibuat <br>";

    $sql = "CREATE TABLE t_list (
        id_list INT AUTO_INCREMENT PRIMARY KEY,
        list TEXT NOT NULL,
        user_id INT NOT NULL,
        status_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES t_users(id_user) ON DELETE CASCADE
    )";

    $conn->exec($sql);
    echo "tabel todolist berhasil dibuat <br>";
    
    echo"
        <a href='/'>gunakan aplikasi</a>
    ";

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}