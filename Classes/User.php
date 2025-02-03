<?php

Class User{
    private PDO $conn;

    public function __construct(PDO $conn){
        $this->conn = $conn;
    }

    public function creatUser(string $username, string $password){
        $sql = "INSERT INTO t_users (username, password) VALUES (:username, :password)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        return $stmt->execute();
    }

    public function getByUsername(string $username, string $password): ?array {
        $sql = "SELECT * FROM t_users WHERE username = :username AND password = :password";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function getById(int $ID) {
        $sql = "SELECT * FROM t_users WHERE id_user = :ID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ID', $ID);
        $stmt->execute();

        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $user;
    }

    public function update(string $username, string $password){
        $sql = "UPDATE t_users SET username = :username, password = :password WHERE id_user = :id_user";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':id_user', $_SESSION['usr']['id_user']);

        return $stmt->execute();
    }

    public function delete(){
        $delTodo = new Todolist($this->conn);
        if ($delTodo->delete()){
            $sql = "DELETE FROM t_users WHERE id_user = :id_user";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_user', $_SESSION['usr']['id_user']);
        }
        return $stmt->execute();
    }


}

